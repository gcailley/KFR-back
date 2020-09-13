<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractRtlqController;
use App\Entity\Association\RtlqAdherent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Dto\Association\RtlqDriveDTO;
use App\Form\Type\Association\RtlqDriveType;
use App\Service\Video\VideoConverterService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\FileinfoMimeTypeGuesser as MimeFileinfoMimeTypeGuesser;
use Symfony\Component\Mime\MimeTypes;

/**
 * @Route("/association/drive")
 */
class DriveController extends AbstractRtlqController
{
    protected $logger;
    protected $videoConverterService;

    public function __construct(LoggerInterface $logger, VideoConverterService $videoConverterService)
    {
        $this->logger = $logger;
        $this->videoConverterService = $videoConverterService;
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
    /**function generateThumbnail($img, $width, $height, $quality = 90)
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
     **/

    private function _getAllByUser($user)
    {
        $userDrive = $this->getUserDrive($user->getId());
        $userWorkingDrive = $this->getWorkingDrive($user->getId());

        $listFilesConverted = $this->dirToArray($userWorkingDrive);
        $listFiles = $this->dirToArray($userDrive);

        $json = [];
        foreach ($listFiles as $key => $value) {
            $filename = $userDrive . '/' . $value;
            $json[] = $this->createDriveDto($filename, in_array($value, $listFilesConverted));
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
    public function getDriveUserByToken(Request $request)
    {
        $tokenAuth = $this->getTokenAuth($request);

        //get user information based on the id associate from the token
        return $this->_getAllByUser($tokenAuth->getUser());
    }

    /**
     * @Route("/by-iduser-{idUser}", methods={"GET"})
     */
    public function getDriveUserByIdUser($idUser, Request $request)
    {
        // check user existance
        $entity = $this->getEntityById(RtlqAdherent::class, $idUser);

        //get user information based on the id associate from the token
        return $this->_getAllByUser($entity);
    }


    private function createDriveDto($file_path, $converting = false): RtlqDriveDTO
    {
        $driveDto = new RtlqDriveDTO();

        $file_name = basename($file_path);
        $data = explode('#', $file_name, 2);
        $driveDto->SetId($data[0]);
        $driveDto->SetName($data[1]);
        $driveDto->SetType(mime_content_type($file_path));
        $driveDto->SetSize($this->humanFilesize($file_path));
        $driveDto->SetThumbnail('');
        $driveDto->SetConverting($converting);

        return $driveDto;
    }

    /**
     * @Route("/by-token", methods={"POST"})
     */
    public function addDriveByToken(Request $request)
    {
        // get user token
        $tokenAuth  = $this->getTokenAuth($request);
        $idUser = $tokenAuth->getUser()->getId();

        return $this->_addDriveByIdUser($idUser, $request);
    }

    /**
     * @Route("/by-iduser-{idUser}", methods={"POST"})
     */
    public function addDriveUserByIdUser($idUser, Request $request)
    {
        // check user existance
        $entity = $this->getEntityById(RtlqAdherent::class, $idUser);
        return $this->_addDriveByIdUser($idUser, $request);
    }


    private function _addDriveByIdUser($idUser, $request)
    {

        // checking input file
        $img = $request->files->get('source');
        $this->logger->error($img === null);
        if ($img === null) {
            return $this->newResponse("source empty.", Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        }

        // generating output filename
        $userDrive = $this->getUserDrive($idUser);
        $uid = md5(uniqid(rand(), true));
        $name = $request->request->get('filename');
        $filename = $uid . '#' . str_replace(" ", "", $name);
        $file_path = $userDrive . DIRECTORY_SEPARATOR . $filename;

        // file move without converting
        $img->move($userDrive, $file_path);
        try {
            if ($this->startsWith($img->getClientMimeType(), "video/")) {
                $workingFile = $this->getWorkingDrive($idUser) . DIRECTORY_SEPARATOR . $filename;
                $this->videoConverterService->convertToMp4(
                    $file_path,
                    $workingFile
                );
            }
            $img == null;
            $dto = $this->createDriveDto($file_path);
            return $this->newResponse($dto, Response::HTTP_ACCEPTED);
        } catch (\Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException $th) {
            $this->cleanFile($file_path);
            $this->logger->error('An error occurred' . $th->getMessage());
            return $this->newResponse($th->getMessage(), Response::HTTP_REQUEST_ENTITY_TOO_LARGE);
        } catch (Exception $th) {
            $this->cleanFile($file_path);
            $this->logger->error('An error occurred' . $th->getMessage());
            return $this->newResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getUserDrive($idUser)
    {
        $userHomeDrive = $this->getUserHomeDirectory($idUser);
        $userDir = $userHomeDrive . DIRECTORY_SEPARATOR . "drive";
        if (!is_dir($userDir)) {
            $this->createPath($userDir);
        }
        return  $userDir;
    }

    private function getWorkingDrive($idUser)
    {
        $userHomeDrive = $this->getUserHomeDirectory($idUser);
        $workingDir = $userHomeDrive . DIRECTORY_SEPARATOR . "converting_video";
        if (!is_dir($workingDir)) {
            $this->createPath($workingDir);
        }
        return  $workingDir;
    }

    private function cleanFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * @Route("/by-token/{id}", methods={"DELETE"}, requirements={"id"="^(\w)*(\.\w+)?$"})
     */
    public function deleteDriveByToken(Request $request, $id)
    {
        // get user token
        $tokenAuth  = $this->getTokenAuth($request);
        return $this->_deleteDriveByUserAndId($tokenAuth->getUser(), $id);
    }
    /**
     * @Route("/by-iduser-{idUser}/{id}", methods={"DELETE"}, requirements={"id"="^(\w)*(\.\w+)?$"})
     */
    public function deleteDriveByIdUser(Request $request, $idUser, $id)
    {
        // check user existance
        $entity = $this->getEntityById(RtlqAdherent::class, $idUser);
        return $this->_deleteDriveByUserAndId($entity, $id);
    }
    private function _deleteDriveByUserAndId($user, $id)
    {
        $idUser = $user->getId();
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
        // get user token
        $tokenAuth  = $this->getTokenAuth($request);

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
        // get user token
        $tokenAuth  = $this->getTokenAuth($request);

        return $this->_checkDriveByUserAndId($tokenAuth->getUser(), $id);
    }
    /**
     * @Route("/by-iduser-{idUser}/{id}", methods={"GET"}, requirements={"id"="^(\w)*$"})
     */
    public function checkDriveByIdUser(Request $request, $idUser, $id)
    {
        // check user existance
        $entity = $this->getEntityById(RtlqAdherent::class, $idUser);

        return $this->_checkDriveByUserAndId($entity, $id);
    }

    private function _checkDriveByUserAndId($user, $id)
    {
        $userDrive = $this->getUserDrive($user->getId());

        $list = $this->dirToArray($userDrive, $id);
        if (sizeof($list) == 0) {
            return $this->newResponse(null, Response::HTTP_ACCEPTED);
        }
        $driveDto = $this->createDriveDto($userDrive . DIRECTORY_SEPARATOR . $list[0]);
        return $this->newResponse($driveDto, Response::HTTP_ACCEPTED);
    }



    /**
     * @Route("/by-token/{id}/key", methods={"GET"}, requirements={"id"="^(\w)*$"})
     */
    public function generateDriveByToken(Request $request, $id)
    {
        // get user token
        $tokenAuth  = $this->getTokenAuth($request);
        return $this->_generateDriveByUser($tokenAuth->getUser(), $id);
    }


    /**
     * @Route("/by-iduser-{idUser}/{id}/key", methods={"GET"}, requirements={"id"="^(\w)*$"})
     */
    public function generateDriveByIdUser(Request $request, $idUser, $id)
    {
        // check user existance
        $entity = $this->getEntityById(RtlqAdherent::class, $idUser);

        return $this->_generateDriveByUser($entity, $id);
    }

    private function _generateDriveByUser($user, $id)
    {
        $plaintext = json_encode(array('userId' => $user->getId(), 'id' => $id));
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

        $idUser = $key['userId'];
        $id = $key['id'];

        $userDrive = $this->getUserDrive($idUser);
        $list = $this->dirToArray($userDrive, $id);
        $this->logger->info("Nombre de fichiers dans le drive : " . sizeof($list) . " with id : " . $id);
        if (sizeof($list) == 0) {
            return $this->returnNotFoundResponse();
        }
        $file_path = $userDrive . DIRECTORY_SEPARATOR . $list[0];
        $file_name = basename($file_path);

        // This should return the file to the browser as response
        $response = new BinaryFileResponse($file_path);

        // To generate a file download, you need the mimetype of the file
        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($file_path);
        $response->headers->set('Content-Type', $mimeType);

        // Set content disposition inline of the file
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $file_name
        );

        return $response;
    }
}
