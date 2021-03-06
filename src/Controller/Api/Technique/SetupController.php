<?php

namespace App\Controller\Api\Technique;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\Api\AbstractRtlqController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\json_encode;

/**
* @Route("/technique/setup")
 */
class SetupController extends AbstractRtlqController {

    const COMMANDS = array(
        "CACHE_CLEAR"=>"php bin/console cache:clear",
        "CACHE_CLEAR_PROD"=>'php bin/console cache:clear --env=prod --no-debug'
    );

    /**
     * @Route("/{action}", methods={"GET"})
     */
     public function executeAction(Request $request, $action){
            $results = array('command' => null, 'state' => null);

            if (SetupController::COMMANDS[$action] != null) {

                echo SetupController::COMMANDS[$action];
                $outputFile = $this->getOutputFile($action);

                $command = SetupController::COMMANDS[$action] . " >$outputFile &";
                
                $results['command'] =$command; 
                $results['state'] .= exec($command);
            }

           return  new Response(json_encode($results), Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("/{action}/results", methods={"GET"})
     */
    public function readAction(Request $request, $action){
        
            $results = "";
            if (SetupController::COMMANDS[$action] != null) {
                $outputFile = $this->getOutputFile($action);
                $section = file_get_contents($outputFile);
            }

           return  new Response(json_encode(utf8_encode( $section)), Response::HTTP_ACCEPTED);
    }


    private function getOutputFile($action) {
        return  sys_get_temp_dir() . DIRECTORY_SEPARATOR .  $action;
    }
}
