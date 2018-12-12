<?php

namespace App\Controller\Api\Association;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\Api\AbstractRtlqController;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Form\Dto\Association\RtlqAdherentDTO;
use App\Entity\Association\RtlqAdherent;
use App\Form\Validator\Association\RtlqAdherentValidator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use App\Service\Security\User\AuthTokenAuthenticator;
use GuzzleHttp\json_encode;
use App\Entity\Security\RtlqAuthToken;

/**
 * @Route("/association/drive")
 */
class DriveController extends AbstractRtlqController {

    private function dirToArray($dir) { 
        
        $result = array(); 
     
        $cdir = scandir($dir); 
        foreach ($cdir as $key => $value) 
        { 
           if (!in_array($value,array(".",".."))) 
           { 
              if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
              { 
                 $result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
              } 
              else 
              { 
                 $result[] = $value; 
              } 
           } 
        } 
        
        return $result; 
     } 

    private function createPath($path) {
        if (is_dir($path)) return true;
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
        $return = $this->createPath($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path) : false;
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
       }
       else {
           throw new Exception("No valid image provided with {$img}.");
       }
   }

    private function getAllByUserId($id) {
        $baseDir = $this->getParameter("user_drive_basedir");
        $userDrive = "${baseDir}/${id}/drive";
        if (!is_dir($userDrive)) {
            $this->createPath($userDrive);
        }

        $list = $this->dirToArray($userDrive);
        
        $json = [];
        foreach ($list as $key => $value) {
            $filename = $userDrive .'/'. $value;
            $ext = mime_content_type($filename);
            $size = $this->humanFilesize($filename);
            $thumbnail = "";
            //$thumbnail = imagecreate($filename);
            $json[] = array( 'name' => $value, 'type' => $ext , 'size' => $size, 'thumbnail'=>$thumbnail );
        }
        
        return $this->newResponse(json_encode($json), Response::HTTP_ACCEPTED);
    }


    private function humanFilesize($filename, $decimals = 2) {
        $bytes = filesize($filename);
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }        

    /**
     * @Route("/by-token", methods={"GET"})
     */
    public function getUserByToken(Request $request) {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        $entityAssociate = $this->getDoctrine()
                ->getRepository(RtlqAuthToken::class)
                    ->findOneBy(array("value"=>$authTokenHeader));
        if (!is_object($entityAssociate)) {
            throw new createAccessDeniedException();
        }
        //get user information based on the id associate from the token
        return $this->getAllByUserId($entityAssociate->getUser()->getId());
    }
}
