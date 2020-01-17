<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractRtlqController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Dto\Association\RtlqDriveDTO;
use App\Form\Type\Association\RtlqDriveType;
use App\Service\Security\User\AuthTokenAuthenticator;
use GuzzleHttp\json_encode;
use App\Entity\Security\RtlqAuthToken;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @Route("/association/drive")
 */
class DriveController extends AbstractRtlqController
{
    protected $logger;

    public function __construct(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }

    function newTypeClass(): string
    {
        return RtlqDriveType::class;
    }
    function newDtoClass(): string
    {
        return RtlqDriveDTO::class;
    }

    function newDto()
    {
        $class = $this->newDtoClass();
        return new $class;
    }

   
    /**
     * 
     * Generate Thumbnail using Imagick class
     *  
     * @param string $img
     * @param string $width
     * @param string $height
     * @param int $quality
     * @return boolean on true
     * @throws Exception
     * @throws ImagickException
     */
    function generateThumbnail($img, $width, $height, $quality = 90)
    {
        if (is_file($img)) {
            $imagick = new Imagick(realpath($img));
            $imagick->setImageFormat('jpeg');
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality($quality);
            $imagick->thumbnailImage($width, $height, false, false);
            $filename_no_ext = reset(explode('.', $img));
            if (file_put_contents($filename_no_ext . '_thumb' . '.jpg', $imagick) === false) {
                throw new Exception("Could not put contents.");
            }
            return true;
        } else {
            throw new Exception("No valid image provided with {$img}.");
        }
    }

    private function getAllByUserId($id)
    {
        $userDrive = $this->getUserHomeDirectory($id) . 'drive';
        if (!is_dir($userDrive)) {
            $this->createPath($userDrive);
        }

        $list = $this->dirToArray($userDrive);

        $json = [];
        foreach ($list as $key => $value) {
            $filename = $userDrive . '/' . $value;

            $json[] = $this->createDriveDto($filename);
        }

        return $this
            ->newResponse(($json), Response::HTTP_ACCEPTED);
    }


    private function humanFilesize($filename, $decimals = 2)
    {
        $bytes = filesize($filename);
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    /**
     * @Route("/by-token", methods={"GET"})
     */
    public function getUserByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        //get user information based on the id associate from the token
        return $this->getAllByUserId($tokenAuth->getUser()->getId());
    }


    private function createDriveDto($file_path): RtlqDriveDTO
    {
        $driveDto = new RtlqDriveDTO();

        $file_name = basename($file_path);
        $data = explode('#', $file_name, 2);
        $driveDto->SetId($data[0]);
        $driveDto->SetName($data[1]);
        $driveDto->SetType(mime_content_type($file_path));
        $driveDto->SetSize($this->humanFilesize($file_path));
        $driveDto->SetThumbnail('');

        return $driveDto;
    }

    /**
     * @Route("/by-token", methods={"POST"})
     */
    public function addDriveByToken(Request $request)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        $img = $request->files->get('source');
        if ($img == null ) {
            return $this->newResponse("source empty.", Response::HTTP_BAD_REQUEST);
        }
        $idUser = $tokenAuth->getUser()->getId();
        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${idUser}/drive";
        if (!is_dir($userDrive)) {
            $this->createPath($userDrive);
        }
        $uid = md5(uniqid(rand(), true));
        $name = $request->request->get('filename');
        $file_path = $userDrive . DIRECTORY_SEPARATOR . $uid . '#' . $name;

        try {
            $img->move($userDrive, basename($file_path));
            $img == null;
            $dto = $this->createDriveDto($file_path);
            return $this->newResponse($dto, Response::HTTP_ACCEPTED);
        } catch (\Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException $th) {
print($th->getMessage());
            $this->logger->error('An error occurred' . $th->getMessage());
            return $this->newResponse($th->getMessage(), Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        } catch (\Throwable $th) {
print($th->getMessage());            
            $this->logger->error('An error occurred' . $th->getMessage());
            return $this->newResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/by-token/{id}", methods={"DELETE"}, requirements={"id"="^(\w)*(\.\w+)?$"})
     */
    public function deleteDriveByToken(Request $request, $id)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        $idUser = $tokenAuth->getUser()->getId();
        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${idUser}/drive/";

        $list = $this->dirToArray($userDrive, $id);
        if (sizeof($list) == 0) {
            return $this->newResponse(null, Response::HTTP_ACCEPTED);
        }
        if (sizeof($list) > 0 && !unlink($userDrive . $list[0])) {
            return $this->newResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->newResponse(null, Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("/by-token/{id}", methods={"PUT"}, requirements={"id"="^(\w)*$"})
     */
    public function renameDriveByToken(Request $request, $id)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        $data = json_decode($request->getContent(), true);
        $entityDto = $this->newDto();
        $form = $this->createForm($this->newTypeClass(), $entityDto);
        $form->submit($data);
        $idUser = $tokenAuth->getUser()->getId();
        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${idUser}/drive/";
        $newUserFile = $userDrive . $id . "#" . $entityDto->getName();

        $list = $this->dirToArray($userDrive, $id);
        if (sizeof($list) == 0) {
            return $this->returnNotFoundResponse();
        }
        $oldUserFile = $userDrive . $list[0];

        if (rename($oldUserFile, $newUserFile)) {
            $driveDto = $this->createDriveDto($newUserFile);
            return $this->newResponse($driveDto, Response::HTTP_ACCEPTED);
        } else {
            return $this->newResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/by-token/{id}", methods={"GET"}, requirements={"id"="^(\w)*$"})
     */
    public function checkDriveByToken(Request $request, $id)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        $idUser = $tokenAuth->getUser()->getId();
        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${idUser}/drive/";

        $list = $this->dirToArray($userDrive, $id);
        if (sizeof($list) == 0) {
            return $this->newResponse(null, Response::HTTP_ACCEPTED);
        }
        $driveDto = $this->createDriveDto($list[0]);
        return $this->newResponse($driveDto, Response::HTTP_ACCEPTED);
    }



    /**
     * @Route("/by-token/{id}/key", methods={"GET"}, requirements={"id"="^(\w)*$"})
     */
    public function generateDriveByToken(Request $request, $id)
    {
        $tokenAuth = $this->extractUserByToken($request);
        if (!is_object($tokenAuth)) {
            return $this->returnNotFoundResponse();
        }

        $plaintext = json_encode(array('userId' => $tokenAuth->getUser()->getId(), 'id' => $id));
        $ciphertext = $this->crypter($plaintext);

        return $this->newResponse($ciphertext, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/by-key", methods={"GET"})
     */
    public function getDriveByToken(Request $request)
    {
        $keyEncrypted = $request->query->get('key');

        $keyDecrypted = $this->decrypter($keyEncrypted);
        $key = \json_decode($keyDecrypted, true);

        $userId = $key['userId'];
        $id = $key['id'];

        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${userId}/drive/";

        $list = $this->dirToArray($userDrive, $id);
        if (sizeof($list) == 0) {
            return $this->returnNotFoundResponse();
        }
        $file_path = $userDrive . $list[0];
        $file_name = basename($file_path);

        // This should return the file to the browser as response
        $response = new BinaryFileResponse($file_path);

        // To generate a file download, you need the mimetype of the file
        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        // Set the mimetype with the guesser or manually
        if ($mimeTypeGuesser->isSupported()) {
            // Guess the mimetype of the file according to the extension of the file
            $response->headers->set('Content-Type', $mimeTypeGuesser->guess($file_path));
        } else {
            // Set the mimetype of the file manually, in this case for a text file is text/plain
            $response->headers->set('Content-Type', 'text/plain');
        }

        // Set content disposition inline of the file
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file_name
        );

        return $response;
    }
}
