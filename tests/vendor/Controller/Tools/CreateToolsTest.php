<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Tools;

use Controller\Association\AdherentControllerTest;
use Controller\Association\GroupeControllerTest;
use Controller\Cotisation\CotisationControllerTest;
use Controller\Saison\SaisonControllerTest;
use Controller\Tresorie\TresoriesCategorieControllerTest;
use Controller\Tresorie\TresoriesControllerTest;
use Controller\Tresorie\TresoriesEtatControllerTest;


/**
 * Description of newPHPClass
 *
 * @author GREGORY
 */
class CreateToolsTest {

    protected $level;

    public function __construct($level=3) {
        $this->level = $level;
    }

    public function logDebug($myDebugVar, $newligne = true) {        
        if ($this->level > 2) {
            fwrite(STDOUT, print_r("   DEBUG > " . $myDebugVar, TRUE));
            if ($newligne)
                fwrite(STDOUT, print_r("\n", TRUE));
        }
    }

    public function creationSaison() {
        $this->logDebug("SaisonsControllerTest  : initializing");
        $testEntity = new SaisonControllerTest();
        $this->logDebug("SaisonsControllerTest  : created");

        $this->logDebug("Saisons sendAndExtract : running");
        var_dump($this->sendAndExtract(null));
        $output = $this->sendAndExtract($testEntity);
        $this->logDebug("Saisons sendAndExtract : done");
        
        return $output;
    }

    public function creationCategorie() {
        $testEntity = new TresoriesCategorieControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationEtat() {
        $testEntity = new TresoriesEtatControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationCotisation($data = array()) {
        $testEntity = new CotisationControllerTest();
        return $this->sendAndExtract($testEntity, $data);
    }

    public function creationAdherent() {
        $testEntity = new AdherentControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationGroupe() {
        $testEntity = new GroupeControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationTresorie() {
        $testEntity = new TresoriesControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    private function sendAndExtract(AbstractRtlqCrudTest $testObject, $data2 = array(), $params = null) {
        print("sendAndExtract : initializing");
//        $testObject->init();
        print("sendAndExtract : initialized");
        
        $data = $testObject->getDataForPost();
        $data = array_replace($data, $data2);

        $this->logDebug("Creating " . $testObject->getApiName());
        $this->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName());
        $this->logDebug(json_encode($data));

        $request = $testObject->getClient()->post(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), $params, json_encode($data));
        $response = $testObject->send($request);

        $dataResponse = json_decode($response->getBody(true), true);
        $id = $dataResponse['id'];
        $testObject->assertNotNull($id);

        $testObject->logDebug("entity $id has been created");
        $testObject->logDebug("--------------------- ");

        return $dataResponse;
    }
}