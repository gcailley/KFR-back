<?php

namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;

class AdherentControllerTest extends AbstractRtlqCrudTest {

    private $_cotisation;
    private $idCotisation;
    private $_groupe;
    private $idGroupe;
    private $_tresorie;
    private $idTresorie;

    public function getApiName() {
        return '/api/association/adherents';
    }

    public function getDataForPost() {
        $data = array(
            "email" => $this->getRandomEmail(),
            "pwd" => $this->getRandomText(6),
            "telephone" => $this->getRandomTelephone(),
            "nom" => $this->getRandomText(6),
            "prenom" => $this->getRandomText(6) . " ",
            "date_naissance" => $this->getRandomDate([1970, 2000]),
            "actif" => false,
            "public" => true,
            "adresse" => $this->getRandomText(),
            "avatar" => $this->getRandomText(6),
            "code_postal" => $this->getRandomNumero(5),
            "ville" => $this->getRandomText(6),
            "date_creation" => $this->getRandomDate([1970, 2000]),
            "date_last_auth" => $this->getRandomDate([1970, 2000]),
            "licence_number" => "",
            "licence_etat" => "",
            "groupes" => [],
            "cotisations" => [],
            "tresories" => []);
        return $data;
    }

    public function getDataForPut() {
        $data = array(
            "email" => $this->getRandomEmail(),
            "pwd" => $this->getRandomText(6),
            "telephone" => $this->getRandomTelephone(),
            "nom" => $this->getRandomText(6),
            "prenom" => $this->getRandomText(6),
            "date_naissance" => $this->getRandomDate([1970, 2000]),
            "actif" => false,
            "public" => true,
            "adresse" => $this->getRandomText(),
            "avatar" => $this->getRandomText(6),
            "code_postal" => $this->getRandomNumero(5),
            "ville" => $this->getRandomText(6),
            "date_creation" => $this->getRandomDate([1970, 2000]),
            "date_last_auth" => $this->getRandomDate([1970, 2000]),
            "licence_number" => $this->getRandomText(6),
            "licence_etat" => "ACTIF",
            "groupes" => [],
            "cotisations" => [],
            "tresories" => []);
        return $data;
    }

    public function assertDataForGet($data, $dataResponse) {
        $this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('prenom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('email', $dataResponse, $data);
        $this->assertArrayHasKeyNull('pwd', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_naissance', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('public', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('actif', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('avatar', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('adresse', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('code_postal', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('ville', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('telephone', $dataResponse, $data);
        if ($dataResponse["licence_number"] == null or $dataResponse["licence_number"] == "") {
            $this->assertArrayHasKeyNull('licence_number', $dataResponse, $data);
        } else {
              $this->assertArrayHasKeyNotNull('licence_number', $dataResponse, $data);
        }
        if ($dataResponse["licence_etat"] == null or $dataResponse["licence_etat"] == "") {
            $this->assertArrayHasKeyNull('licence_etat', $dataResponse, $data);
        } else {
              $this->assertArrayHasKeyNotNull('licence_etat', $dataResponse, $data);
        }
    }

    public function assertDataForPost($data, $dataResponse) {
        $this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('prenom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('email', $dataResponse, $data);
        $this->assertArrayHasKeyNull('pwd', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_naissance', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('public', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('actif', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('avatar', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('adresse', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('code_postal', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('ville', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('telephone', $dataResponse, $data);
        $this->assertArrayHasKeyNull('licence_number', $dataResponse, $data);
        $this->assertArrayHasKeyNull('licence_etat', $dataResponse, $data);
    }

    public function assertDataForPut($data, $dataResponse) {
        $this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('prenom', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('email', $dataResponse, $data);
        $this->assertArrayHasKeyNull('pwd', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_naissance', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('public', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('actif', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('avatar', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('adresse', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('code_postal', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('ville', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('telephone', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('licence_number', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('licence_etat', $dataResponse, $data);
    }

    protected function assertPreConditions() {
        parent::assertPreConditions();
        $this->init();
    }

    public function init() {
        $this->_cotisation = $this->getUtil()->creationCotisation();
        $this->idCotisation = $this->_cotisation['id'];

        $this->_groupe = $this->getUtil()->creationGroupe();
        $this->idGroupe = $this->_groupe['id'];        
    }
    
    public function initTresorie(){
        $this->_tresorie = $this->getUtil()->creationTresorie(false);
        $this->idTresorie = $this->_tresorie['id'];
    }

    //************************* COTISATION ********************************//

    const URL_COTISATIONS = "cotisations/";

    public function getUrlGetCotisations($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_COTISATIONS;
    }

    public function getUrlAddCotisation($adherentId, $cotisationId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_COTISATIONS . $cotisationId;
    }

    private function addCotisation($adherentId, $cotisationId, $statusCodeExpected = null) {
        $request = $this->getClient()->post($this->getUrlAddCotisation($adherentId, $cotisationId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function removeCotisation($adherentId, $cotisationId, $statusCodeExpected = null) {
        $request = $this->getClient()->delete($this->getUrlAddCotisation($adherentId, $cotisationId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function getCotisations($adherentId, $statusCodeExpected = null) {
        $request = $this->getClient()->get($this->getUrlGetCotisations($adherentId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    public function testAddCotisation() {
        $this->logInfo("Creating new adherent");
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $this->addCotisation($adherentId, $this->idCotisation, 200);
        $response = $this->getCotisations($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse as $cotisation) {
            if ($cotisation == $this->idCotisation) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Cotisation $this->idCotisation non trouvee");
    }

    public function testGetCotisations() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $maxCotisations = 2;
        for ($i = 0; $i < $maxCotisations; $i++) {
            $this->logInfo("Adding Cotisation $i");
            $cotisation = $this->getUtil()->creationCotisation();
            $response = $this->addCotisation($adherentId, $cotisation ['id'], 201);
        }

        $response = $this->getCotisations($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals($maxCotisations, sizeof($dataResponse));
    }

    public function testAdd2CotisationsMemeSaison() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $cotisationOK = $this->_cotisation;
        $cotisationKO = $this->getUtil()->creationCotisation(array("saison_id" => $cotisationOK["saison_id"]));

        $this->assertEquals($cotisationOK["saison_id"], $cotisationKO["saison_id"], "les deux saisons ne sont pas les mêmes");

        $response = $this->addCotisation($adherentId, $cotisationOK['id'], 201);
        $this->logInfo("Cotisation added");

        $response = $this->addCotisation($adherentId, $cotisationKO['id'], 409);

        $response = $this->getCotisations($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
    }

    public function testAdd2CotisationsIdentique() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $cotisationOK = $this->_cotisation;

        $response = $this->addCotisation($adherentId, $cotisationOK['id'], 201);
        $this->logInfo("Cotisation added");

        $response = $this->addCotisation($adherentId, $cotisationOK['id'], 201);
        $this->logInfo("Cotisation added");

        $response = $this->getCotisations($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
    }

    public function testRemoveCotisations() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $cotisationOK = $this->_cotisation;

        $response = $this->addCotisation($adherentId, $cotisationOK['id'], 201);
        $this->logInfo("Cotisation added");

        $response = $this->removeCotisation($adherentId, $cotisationOK['id'], 201);
        $this->logInfo("Cotisation added");

        $response = $this->getCotisations($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

    //************************* GROUPE ********************************//

    const URL_GROUPES = "groupes/";

    public function getUrlGetGroupes($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_GROUPES;
    }

    public function getUrlAddGroupe($adherentId, $groupeId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_GROUPES . $groupeId;
    }

    private function addGroupe($adherentId, $groupeId, $statusCodeExpected = null) {
        $request = $this->getClient()->post($this->getUrlAddGroupe($adherentId, $groupeId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function removeGroupe($adherentId, $groupeId, $statusCodeExpected = null) {
        $request = $this->getClient()->delete($this->getUrlAddGroupe($adherentId, $groupeId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function getGroupes($adherentId, $statusCodeExpected = null) {
        $request = $this->getClient()->get($this->getUrlGetGroupes($adherentId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    public function testAddGroupe() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $this->addGroupe($adherentId, $this->idGroupe, 201);

        $response = $this->getGroupes($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse as $groupe) {
            if ($groupe == $this->idGroupe) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Groupe non trouve");
    }

    public function testGetGroupes() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $maxEntities = 2;
        for ($i = 0; $i < $maxEntities; $i++) {
            $this->logInfo("Adding Groupe $i");
            $entity = $this->getUtil()->creationGroupe();
            $this->addGroupe($adherentId, $entity ['id'], 201);
        }

        $response = $this->getGroupes($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals($maxEntities, sizeof($dataResponse));
    }

    public function testAdd2GroupesIdentique() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_groupe;

        $this->addGroupe($adherentId, $entityOK['id'], 201);
        $this->logInfo("Groupe added");

        $this->addGroupe($adherentId, $entityOK['id'], 201);
        $this->logInfo("Groupe added");

        $response = $this->getGroupes($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
    }

    public function testRemoveGroupes() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_groupe;

        $this->addGroupe($adherentId, $entityOK['id'], 201);
        $this->logInfo("Groupe added");

        $this->removeGroupe($adherentId, $entityOK['id'], 201);
        $this->logInfo("Groupe added");

        $response = $this->getGroupes($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

    //************************* TRESORIE ********************************//

    const URL_TRESORIES = "tresories/";

    public function getUrlGetTresories($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_TRESORIES;
    }

    public function getUrlAddTresorie($adherentId, $tresorieId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_TRESORIES . $tresorieId;
    }

    private function addTresorie($adherentId, $tresorieId, $statusCodeExpected = null) {
        $request = $this->getClient()->post($this->getUrlAddTresorie($adherentId, $tresorieId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function removeTresorie($adherentId, $tresorieId, $statusCodeExpected = null) {
        $request = $this->getClient()->delete($this->getUrlAddTresorie($adherentId, $tresorieId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function getTresories($adherentId, $statusCodeExpected = null) {
        $request = $this->getClient()->get($this->getUrlGetTresories($adherentId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    public function testAddTresorie() {
        $this->logDebug("=======" . __METHOD__ . "=======");
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $this->addTresorie($adherentId, $this->idTresorie, 201);

        $response = $this->getTresories($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse as $tresorie) {
            if ($tresorie == $this->idTresorie) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, "Tresorie non trouve");
    }

    public function testGetTresories() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $maxEntities = 2;
        for ($i = 0; $i < $maxEntities; $i++) {
            $this->logInfo("Adding Tresorie $i");
            $entity = $this->getUtil()->creationTresorie();
            $this->addTresorie($adherentId, $entity ['id'], 201);
        }

        $response = $this->getTresories($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals($maxEntities, sizeof($dataResponse));
    }

    public function testAdd2TresoriesIdentique() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_tresorie;

        $this->addTresorie($adherentId, $entityOK['id'], 201);
        $this->logInfo("Tresorie added");

        $this->addTresorie($adherentId, $entityOK['id'], 201);
        $this->logInfo("Tresorie added");

        $response = $this->getTresories($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
    }

    public function testRemoveTresories() {
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_tresorie;

        $this->addTresorie($adherentId, $entityOK['id'], 201);
        $this->logInfo("Tresorie added");

        $this->removeTresorie($adherentId, $entityOK['id'], 201);
        $this->logInfo("Tresorie added");

        $response = $this->getTresories($adherentId, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

}
