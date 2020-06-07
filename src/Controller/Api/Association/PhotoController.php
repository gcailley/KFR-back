<?php

namespace App\Controller\Api\Association;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqPhotoBuilder;
use App\Form\Dto\Association\RtlqPhotoDTO;
use App\Entity\Association\RtlqPhoto;
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Type\Association\RtlqPhotoType;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Model\FileBinary;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @Route("/association/photos")
 */
class PhotoController extends AbstractCrudApiController
{

    private $filterManager;
    private $params;
    function __construct(FilterManager $filterManager, ParameterBagInterface $params)
    {
        $this->filterManager = $filterManager;
        $this->params = $params;
        $this->init();
    }


    function newTypeClass(): string
    {
        return RtlqPhotoType::class;
    }
    function newDtoClass(): string
    {
        return RtlqPhotoDTO::class;
    }
    function newBuilderClass(): string
    {
        return RtlqPhotoBuilder::class;
    }
    function newModeleClass(): string
    {
        return RtlqPhoto::class;
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response = true)
    {
        // get parameters
        $directory_id = $request->query->get('directory_id');
        if ($directory_id  === null) {
            return parent::getAllAction($request);
        } else {
            return $this->getAllPhotoInDirectory($directory_id);
        }
    }


    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getByIdAction(Request $request, $id)
    {
        $modele = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($modele)) {
            throw $this->createNotFoundException();
        }

        $thumbnail = $request->query->get('thumbnail');
        $minetype = $modele->getSourceMimeType();
        if ($thumbnail === 'true') {
            $photosDir = $this->getDirectory("thumbnails_drive_basedir");
            $filename = $modele->getThumbnailName();
            $filesize = $modele->getThumbnailFileSize();
        } else {
            $photosDir = $this->getDirectory("photos_drive_basedir");
            $filename = $modele->getSourceName();
            $filesize = $modele->getSourceFileSize();
        }

        // decode image
        $image = $photosDir . DIRECTORY_SEPARATOR  . $filename;
        if (file_exists($image)) {
            $decoded = (file_get_contents($image));
            $response = new Response();

            //extraction à l'upload de ces informations puis à mettre dans la base de données
            $response->headers->set('Content-type', $minetype);
            $response->headers->set('Content-length', $filesize);

            // Send headers before outputting anything
            $response->sendHeaders();
            $response->setContent($decoded);
        } else {
            $response = $this->returnNotFoundResponse();
        }
        return  $response;
    }


    private function getAllPhotoInDirectory($directory_id)
    {

        $directoryEntity = new RtlqPhotoDirectory();
        $directoryEntity->setId($directory_id);

        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->findBy(array("repertoire" => $directoryEntity));

        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }

    // TODO MERGE WITH DRIVE CONTROLLER
    private function getDirectory($param_name)
    {
        $dir = $this->params->get('photos')[$param_name];
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        return $dir;
    }

    protected function innerUpdateAction($em, $entityMetier)
    {
        dump($entityMetier);
        $this->saveIntoFile($entityMetier);

    }


    protected function innerCreateAction($em, $entityMetier)
    {
        $this->saveIntoFile($entityMetier);
    }

    private function saveIntoFile($entityMetier)
    {
        if ($entityMetier->getSourceBase64() == null) return;

        $photosDir = $this->getDirectory("photos_drive_basedir");
        $thumbnailsDir = $this->getDirectory("thumbnails_drive_basedir");
        //extract information sur la photo
        $file_path = $photosDir . DIRECTORY_SEPARATOR . $entityMetier->getRepertoire()->getId() . '-rtlq-' . md5(uniqid(rand(), true)) . '.jpeg';

        $file_name = basename($file_path);
        $base64 = $entityMetier->getSourceBase64();
        $base64_extension = substr($base64, 0, 23);

        //creation de la photo sur le serveur
        $decoded = base64_decode(substr($base64, 22));
        file_put_contents($file_path, $decoded);

        //Sauvegarde de la photo dans l'entité metier
        $entityMetier->setSourceMimeType(mime_content_type($file_path));
        $entityMetier->setSourceFileSize(filesize($file_path));
        $entityMetier->setSourceName($file_name);
        $entityMetier->setSourceBase64(null);

        //extract information sur la photo pour le creation du thumbnail
        $thumbnail_path = $thumbnailsDir . DIRECTORY_SEPARATOR . $file_name;
        $this->createThumbnail($file_path, $thumbnail_path, "squared_thumbnail");

        //Sauvegarde du thumbnail dans l'entité metier
        $entityMetier->setThumbnailMimeType(mime_content_type($thumbnail_path));
        $entityMetier->setThumbnailFileSize(filesize($thumbnail_path));
        $entityMetier->setThumbnailName($file_name);
        $entityMetier->setThumbnailBase64(null);
    }

    /**
     * Write a thumbnail image using the LiipImagineBundle
     * 
     * @param string $fullSizeImg path where full size upload is stored e.g. uploads/attachments
     * @param string $thumbAbsPath full absolute path to attachment directory e.g. /var/www/project1/images/thumbs/
     * @param string $filter filter defined in config e.g. my_thumb
     */
    public function createThumbnail($fullSizeImg, $thumbAbsPath, $filter)
    {

        //$image = $dataManager->find($filter, $fullSizeImg);                    // find the image and determine its type        
        $bimage = new FileBinary($fullSizeImg, "jpeg");
        $response = $this->filterManager->applyFilter($bimage, $filter);

        $thumb = $response->getContent();                               // get the image from the response

        $f = fopen($thumbAbsPath, 'w');                                 // create thumbnail file
        fwrite($f, $thumb);                                             // write the thumbnail
        fclose($f);                                                     // close the file
    }
}
