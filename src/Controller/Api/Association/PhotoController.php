<?php

namespace App\Controller\Api\Association;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqPhotoBuilder;
use App\Form\Dto\Association\RtlqPhotoDTO;
use App\Controller\Api\AbstractApiController;
use App\Entity\Association\RtlqPhotoDirectory;


use Liip\ImagineBundle\Model\FileBinary;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Service\FilterService;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Controller\ImagineController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
/**
 * @Route("/association/photos")
 */
class PhotoController extends AbstractCrudApiController
{

    private $filterManager;
    private $params;
    function __construct(ImagineController $imagineController, ParameterBagInterface $params)
    {
        $this->filterManager = $imagineController->filterService->filterManager;
        $this->params=$params;
        $this->init();
    }

    
    function getName()
    {
        return 'App:Association\RtlqPhoto';
    }

    function getNameType()
    {
        return "App\Form\Type\Association\RtlqPhotoType";
    }

    protected function getBuilder()
    {
        return new RtlqPhotoBuilder();
    }

    function newDto()
    {
        return new RtlqPhotoDTO();
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
        $modele = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($modele)) {
            throw $this->createNotFoundException();
        }

        $thumbnail = $request->query->get('thumbnail');
        if ($thumbnail === 'true') {
            $photosDir = $this->getDirectory("thumbnails_drive_basedir");
            $filename = $modele->getThumbnailName();
            $filesize = $modele->getThumbnailFileSize();
        } else {
            $photosDir = $this->getDirectory("photos_drive_basedir");
            $filename = $modele->getSourceName();
            $minetype = $modele->getSourceMimeType();
            $filesize = $modele->getSourceFileSize();
        }

        // decode image
        $decoded = (file_get_contents($photosDir . DIRECTORY_SEPARATOR  . $filename));
        $response = new Response();
        
        //extraction à l'upload de ces informations puis à mettre dans la base de données
        $response->headers->set('Content-type', $minetype);
        $response->headers->set('Content-length', $filesize);
        
        // Send headers before outputting anything
        $response->sendHeaders();
        $response->setContent($decoded);

        return  $response;
    }


    private function getAllPhotoInDirectory($directory_id) {

        $directoryEntity = new RtlqPhotoDirectory ();
        $directoryEntity->setId($directory_id);

        $entities = $this->getDoctrine()
        ->getRepository($this->getName())
            ->findBy(array("repertoire"=>$directoryEntity));

        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }

    // TODO MERGE WITH DRIVE CONTROLLER
    private function getDirectory($param_name) {
        $dir = $this->params->get('photos')[$param_name];
        if (!is_dir($dir)) {
            mkdir ($dir, 0750, true);
        }
        return $dir;
    }

    protected function updateBeforeSaved($em, $entityMetier) {
        $this->saveIntoFile($entityMetier);
    }


    protected function innerCreateAction($em, $entityMetier) {
        $this->saveIntoFile($entityMetier);
    }

    private function saveIntoFile($entityMetier) {
        $photosDir = $this->getDirectory("photos_drive_basedir");
        $thumbnailsDir = $this->getDirectory("thumbnails_drive_basedir");
        //extract information sur la photo
        $file_path = $photosDir . DIRECTORY_SEPARATOR . $entityMetier->getRepertoire()->getId() . '-rtlq-'. md5(uniqid(rand(), true)) . '.jpeg';
        
        $file_name = basename($file_path);
        $base64 = $entityMetier->getSourceBase64();
        $base64_extension = substr($base64,0,23);

        $decoded = base64_decode(substr($base64,22));        
        file_put_contents($file_path, $decoded);
        $entityMetier->setSourceMimeType(mime_content_type($file_path));
        $entityMetier->setSourceFileSize(filesize($file_path));
        $entityMetier->setSourceName($file_name);
        $entityMetier->setSourceBase64(null);
        
        //extract information sur la photo
        $thumbnail_path = $thumbnailsDir . DIRECTORY_SEPARATOR . $file_name;
        $this->createThumbnail($file_path, $thumbnail_path, "squared_thumbnail");
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
    public function createThumbnail($fullSizeImg, $thumbAbsPath, $filter) {
        
        //$image = $dataManager->find($filter, $fullSizeImg);                    // find the image and determine its type        
        $bimage = new FileBinary ($fullSizeImg, "jpeg");
        $response = $this->filterManager->applyFilter($bimage, $filter);

        $thumb = $response->getContent();                               // get the image from the response

        $f = fopen($thumbAbsPath, 'w');                                 // create thumbnail file
        fwrite($f, $thumb);                                             // write the thumbnail
        fclose($f);                                                     // close the file
    }

}
