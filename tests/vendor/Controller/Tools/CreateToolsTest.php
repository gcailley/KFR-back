<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller\Tools;
use Symfony\Component\HttpFoundation\Response;

use Controller\Association\AdherentControllerTest;
use Controller\Association\GroupeControllerTest;
use Controller\Cotisation\CotisationControllerTest;
use Controller\Saison\SaisonControllerTest;
use Controller\Tresorie\TresoriesCategorieControllerTest;
use Controller\Tresorie\TresoriesControllerTest;
use Controller\Tresorie\TresoriesEtatControllerTest;
use Controller\AbstractRtlqCrudTest;

/**
 * Description of newPHPClass
 *
 * @author GREGORY
 */
class CreateToolsTest {

    protected $level;
    protected $saisonControllerTest = null;
    protected $saison = null;
    protected $tresoriesCategorieControllerTest = null;
    protected $tresoriesCategorie = null;
    protected $tresoriesEtatControllerTest = null;
    protected $tresoriesEtat = null;
    protected $groupeControllerTest = null;
    protected $groupe = null;
    protected $cotisationControllerTest = null;
    protected $cotisation = null;
    protected $adherentControllerTest = null;
    protected $adherent = null;
    protected $tresoriesControllerTest = null;
    protected $tresories = null;
    static protected $map = array(
        "adherent" => "Controller\Association\AdherentControllerTest",
        "groupe" => "Controller\Association\GroupeControllerTest",
        "cotisation" => "Controller\Cotisation\CotisationControllerTest",
        "saison" => "Controller\Saison\SaisonControllerTest",
        "tresoriesCategorie" => "Controller\Tresorie\TresoriesCategorieControllerTest",
        "tresories" => "Controller\Tresorie\TresoriesControllerTest",
        "tresoriesEtat" => "Controller\Tresorie\TresoriesEtatControllerTest",
    );

    /**
     * @var Singleton
     * @access private
     * @static
     */
    private static $_instance = null;

    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return Singleton
     */
    public static function getInstance($level = 3) {

        if (is_null(self::$_instance)) {
            self::$_instance = new CreateToolsTest($level);
        }

        return self::$_instance;
    }

    public function __construct($level) {
        $this->level = $level;
    }

    public function logDebug($myDebugVar, $methodeName = "", $newligne = true) {
        if ($this->level > 2) {
            fwrite(STDOUT, print_r("   DEBUG > " . $methodeName . "> " . $myDebugVar, TRUE));
            if ($newligne)
                fwrite(STDOUT, print_r("\n", TRUE));
        }
    }

    public function creationSaison($createNew = false) {
        return $this->creationEntity("saison", $createNew);
    }

    public function creationCategorie($createNew = false) {
        return $this->creationEntity("tresoriesCategorie", $createNew);
    }

    public function creationEtat($createNew = false) {
        return $this->creationEntity("tresoriesEtat", $createNew);
    }

    public function creationCotisation($data = array(), $createNew=false) {
        return $this->creationEntity("cotisation", $createNew, array("data"=>$data));
    }

    public function creationTresorie($createNew = true, $withAdherent = true) {
        $this->logDebug("======= START =========", __METHOD__);
        if ($this->tresories != null) {
            return $this->tresories;
        }

        $this->tresoriesControllerTest = new TresoriesControllerTest();
        $this->tresoriesControllerTest->init($withAdherent);

        if (!$createNew) {
            $this->tresories = $this->getData($this->tresoriesControllerTest);
        }
        if ($this->tresories == null) {
            $this->tresories = $this->sendAndExtract($this->tresoriesControllerTest);
        }

        $this->tresories = $this->sendAndExtract($this->tresoriesControllerTest);

        return $this->tresories;
    }

    public function creationAdherent($createNew = false) {
        return $this->creationEntity("adherent", $createNew);
    }

    public function creationGroupe($createNew = false) {
        return $this->creationEntity("groupe", $createNew);
    }

    private function creationEntity($entity, $createNew, $options=array()) {
        $attributControllerTest = $entity . "ControllerTest";
        $entityControllerTestClass = CreateToolsTest::$map[$entity];

        if (!$createNew) {
            if ($this->$entity != null) {
                return $this->$entity;
            }
            if ($this->$attributControllerTest == null) {
                $this->$attributControllerTest = new $entityControllerTestClass;
                $this->$attributControllerTest->init();
            }
            $this->$entity = $this->getData($this->$attributControllerTest);
            if ($this->$entity == null) {
                $this->$entity = $this->sendAndExtract($this->$attributControllerTest);
            }
        } else {
            $this->$attributControllerTest = new $entityControllerTestClass;
            $this->$attributControllerTest->init();
            
            $this->$entity = $this->sendAndExtract($this->$attributControllerTest, array_keys($options, "data"));
        }
        return $this->$entity;
    }

    private function sendAndExtract(AbstractRtlqCrudTest $testObject, $data2 = array(), $params = null) {
        $this->logDebug("======= START =========", __METHOD__);

        $data = $testObject->getDataForPost();
        $data = array_replace($data, $data2);

        $this->logDebug("Creating " . $testObject->getApiName(), __METHOD__);
        $this->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), __METHOD__);
        $this->logDebug(json_encode($data));

        $request = $testObject->getClient()->post(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), $params, json_encode($data));
        $response = $testObject->send($request, Response::HTTP_CREATED);

        $dataResponse = json_decode($response->getBody(true), true);
        $id = $dataResponse['id'];
        $testObject->assertNotNull($id);

        $testObject->logDebug("entity $id has been created", __METHOD__);
        $testObject->logDebug("--------------------- ", __METHOD__);

        return $dataResponse;
    }

    private function getData(AbstractRtlqCrudTest $testObject) {
        $this->logDebug("======= START =========", __METHOD__);
        $this->logDebug("Extracting " . $testObject->getApiName(), __METHOD__);
        $this->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), __METHOD__);

        $request = $testObject->getClient()->get(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), null, null);
        $response = $testObject->send($request, Response::HTTP_ACCEPTED);

        $dataResponse = json_decode($response->getBody(true), true);
        if (sizeof($dataResponse) > 0) {
            $dataResponse = $dataResponse[0];
            $id = $dataResponse['id'];
            $testObject->assertNotNull($id);

            $testObject->logDebug("entity $id has been created", __METHOD__);
            $testObject->logDebug("--------------------- ", __METHOD__);
        } else {
            $dataResponse = null;
        }
        return $dataResponse;
    }

}
