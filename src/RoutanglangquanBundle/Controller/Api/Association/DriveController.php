<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use Symfony\Component\HttpFoundation\Request;
use RoutanglangquanBundle\Controller\Api\AbstractController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Form\Validator\Association\RtlqAdherentValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use RoutanglangquanBundle\Service\Security\User\AuthTokenAuthenticator;
use function GuzzleHttp\json_encode;

/**
 * @Route("/api/association/drive")
 */
class DriveController extends AbstractController {

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
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $size = $this->humanFilesize($filename);
            $json[] = array( 'name' => $value, 'type' => $ext , 'size' => $size );
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
     * @Route("/by-token")
     * @Method("GET")
     */
    public function getUserByToken(Request $request) {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        $entityAssociate = $this->getDoctrine()
                ->getRepository("RoutanglangquanBundle\Entity\Security\RtlqAuthToken")
                    ->findOneBy(array("value"=>$authTokenHeader));
        if (!is_object($entityAssociate)) {
            throw new createAccessDeniedException();
        }
        //get user information based on the id associate from the token
        return $this->getAllByUserId($entityAssociate->getUser()->getId());
    }
}
