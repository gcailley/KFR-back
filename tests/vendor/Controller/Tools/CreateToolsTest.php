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
    protected $categorie = null;
    protected $tresoriesEtatControllerTest = null;
    protected $etat=null;
    protected $groupeControllerTest=null;
    protected $groupe=null;
    protected $cotisationControllerTest=null;
    protected $cotisation=null;
    protected $adherentControllerTest =null;
    protected $adherent=null;
    protected $tresoriesControllerTest =null;
    protected $tresories=null;
    


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

    public function logDebug($myDebugVar, $newligne = true) {
        if ($this->level > 2) {
            fwrite(STDOUT, print_r("   DEBUG > " . $myDebugVar, TRUE));
            if ($newligne)
                fwrite(STDOUT, print_r("\n", TRUE));
        }
    }

    public function creationSaison() {
        if ($this->saison != null) {
            return $this->saison;
        }

        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->saisonControllerTest = new SaisonControllerTest();
        $this->saisonControllerTest->init();
        $this->saison = $this->getData($this->saisonControllerTest);
        if ($this->saison == null) {
            $this->saison = $this->sendAndExtract($this->saisonControllerTest);
        }

        return $this->saison;
    }

    public function creationCategorie() {
        if ($this->categorie != null) {
            return $this->categorie;
        }
        $this->logDebug("=======" . __METHOD__ . "=======");

        $this->tresoriesCategorieControllerTest = new TresoriesCategorieControllerTest();
        $this->tresoriesCategorieControllerTest->init();
        $this->categorie= $this->getData($this->tresoriesCategorieControllerTest);
        if ($this->categorie == null) {
            $this->categorie = $this->sendAndExtract($this->tresoriesCategorieControllerTest);
        }
        return $this->categorie;
    }

    public function creationEtat() {
        if ($this->etat != null) {
            return $this->etat;
        }
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->tresoriesEtatControllerTest = new TresoriesEtatControllerTest();
        $this->tresoriesEtatControllerTest->init();
        
        $this->etat = $this->getData($this->tresoriesEtatControllerTest);
        if ($this->etat  == null) {
            $this->etat = $this->sendAndExtract($this->tresoriesEtatControllerTest);
        }
        

        return $this->etat;
    }

    public function creationCotisation($data = array()) {
        if ($this->cotisation != null) {
            return $this->cotisation;
        }
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->cotisationControllerTest = new CotisationControllerTest();
        $this->cotisationControllerTest ->init();
        $this->cotisation = $this->sendAndExtract($this->cotisationControllerTest );

        return $this->cotisation;
        
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $testEntity = new CotisationControllerTest();
        $testEntity->init();

        return $this->sendAndExtract($testEntity, $data);
    }

    public function creationAdherent() {
        if ($this->adherent != null) {
            return $this->adherent;
        }
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->adherentControllerTest = new AdherentControllerTest();
        $this->adherentControllerTest ->init();
        $this->adherent = $this->sendAndExtract($this->adherentControllerTest );

        return $this->adherent;
    }

    public function creationGroupe() {
        if ($this->groupe != null) {
            return $this->groupe;
        }
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->groupeControllerTest = new GroupeControllerTest();
        $this->groupeControllerTest->init();
        $this->groupe = $this->sendAndExtract($this->groupeControllerTest);

        return $this->groupe;
    }

    public function creationTresorie($createNew=true, $withAdherent=true) {
        if ($this->tresories != null) {
            return $this->tresories;
        }
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->tresoriesControllerTest = new TresoriesControllerTest();
        $this->tresoriesControllerTest ->init($withAdherent);
        
        if (!$createNew) {
            $this->tresories = $this->getData($this->tresoriesControllerTest);
        }
        if ($this->tresories  == null) {
            $this->tresories = $this->sendAndExtract($this->tresoriesControllerTest);
        }
        
        $this->tresories = $this->sendAndExtract($this->tresoriesControllerTest );

        return $this->tresories;
        
        
        $this->logDebug("=======" . __METHOD__ . "=======");
        $testEntity = new TresoriesControllerTest();
        $testEntity->init();

        return $this->sendAndExtract($testEntity);
    }

    private function sendAndExtract(AbstractRtlqCrudTest $testObject, $data2 = array(), $params = null) {
        $this->logDebug("=======" . __METHOD__ . "=======");

        $data = $testObject->getDataForPost();
        $data = array_replace($data, $data2);

        $this->logDebug("Creating " . $testObject->getApiName());
        $this->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName());
        $this->logDebug(json_encode($data));

        $request = $testObject->getClient()->post(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), $params, json_encode($data));
        $response = $testObject->send($request, 201);

        $dataResponse = json_decode($response->getBody(true), true);
        $id = $dataResponse['id'];
        $testObject->assertNotNull($id);

        $testObject->logDebug("entity $id has been created");
        $testObject->logDebug("--------------------- ");

        return $dataResponse;
    }

    private function getData(AbstractRtlqCrudTest $testObject) {
        $this->logDebug("=======" . __METHOD__ . "=======");
        $this->logDebug("Extracting " . $testObject->getApiName());
        $this->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName());

        $request = $testObject->getClient()->get(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), null, null);
        $response = $testObject->send($request, 201);

        $dataResponse = json_decode($response->getBody(true), true);
        if (sizeof($dataResponse) > 0) {
            $dataResponse = $dataResponse[0];
            $id = $dataResponse['id'];
            $testObject->assertNotNull($id);

            $testObject->logDebug("entity $id has been created");
            $testObject->logDebug("--------------------- ");
        } else {
            $dataResponse = null;
        }
        return $dataResponse;
    }

}
