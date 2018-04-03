<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqPhotoBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqPhotoDTO;
use RoutanglangquanBundle\Controller\Api\AbstractApiController;
use RoutanglangquanBundle\Entity\Association\RtlqPhotoDirectory;

use Liip\ImagineBundle\Model\FileBinary;
/**
 * @Route("/association/photos")
 */
class PhotoController extends AbstractCrudApiController
{
    function getName()
    {
        return 'RoutanglangquanBundle:Association\RtlqPhoto';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqPhotoType";
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
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request)
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
     * @Route("/{id}")
     * @Method("GET")
     */
    public function getByIdAction(Request $request, $id)
    {
        $modele = $this->getDoctrine()->getRepository($this->getName())->find($id);

        if (!is_object($modele)) {
            throw $this->createNotFoundException();
        }


        $thumbnail = $request->query->get('thumbnail');
        if ($thumbnail === 'true') {
            $base64 = $modele->getThumbnailBase64();
            $minetype = $modele->getThumbnailMimeType();
            $filesize = $modele->getThumbnailFileSize();
        } else {
            $base64 = $modele->getSourceBase64();
            $minetype = $modele->getSourceMimeType();
            $filesize = $modele->getSourceFileSize();
        }

        // decode image
        $data  = stream_get_contents($base64);
        $decoded = base64_decode(substr($data,22));

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

        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->builder->modelesToDtos($entities, $this);
        }
        return new Response(json_encode($dto_entities), Response::HTTP_ACCEPTED);
    }

    protected function innerCreateAction($em, $entityMetier) {

        
        //extract information sur la photo
        $filename = tempnam(sys_get_temp_dir(), 'rtlq') . '.jpeg';
        $base64 = $entityMetier->getSourceBase64();
        //var_dump($base64);

        $base64_extension = substr($base64,0,23);
        $decoded = base64_decode(substr($base64,22));        
        file_put_contents($filename, $decoded);
        $entityMetier->setSourceMimeType(mime_content_type($filename));
        $entityMetier->setSourceFileSize(filesize($filename));
        
        //extract information sur la photo
        $filename_thumbnail = tempnam(sys_get_temp_dir(), 'rtlq_thumbnail') . '.jpeg';
        $this->createThumbnail($filename, $filename_thumbnail, "my_heighten_filter");
        $base64 = base64_encode(file_get_contents($filename_thumbnail));
        //var_dump($base64);
        $entityMetier->setThumbnailBase64($base64_extension . $base64);
        $entityMetier->setThumbnailMimeType(mime_content_type($filename_thumbnail));
        $entityMetier->setThumbnailFileSize(filesize($filename_thumbnail));

    }

    /**
     * Write a thumbnail image using the LiipImagineBundle
     * 
     * @param string $fullSizeImg path where full size upload is stored e.g. uploads/attachments
     * @param string $thumbAbsPath full absolute path to attachment directory e.g. /var/www/project1/images/thumbs/
     * @param string $filter filter defined in config e.g. my_thumb
     */
    public function createThumbnail($fullSizeImg, $thumbAbsPath, $filter) {
        $dataManager = $this->get('liip_imagine.data.manager');    // the data manager service
        $filterManager = $this->get('liip_imagine.filter.manager'); // the filter manager service

        //$image = $dataManager->find($filter, $fullSizeImg);                    // find the image and determine its type        
        $bimage = new FileBinary ($fullSizeImg, "jpeg");
        $response = $filterManager->applyFilter($bimage, $filter);

        $thumb = $response->getContent();                               // get the image from the response

        $f = fopen($thumbAbsPath, 'w');                                 // create thumbnail file
        fwrite($f, $thumb);                                             // write the thumbnail
        fclose($f);                                                     // close the file
    }

}
