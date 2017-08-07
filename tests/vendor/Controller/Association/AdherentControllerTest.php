<?php

namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;

use Symfony\Component\HttpFoundation\Response;

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
            "avatar" => "https://upload.wikimedia.org/wikipedia/commons/d/d3/User_Circle.png",
            "code_postal" => $this->getRandomNumero(5),
            "ville" => $this->getRandomText(6),
            "date_creation" => $this->getRandomDate([1970, 2000]),
            "date_last_auth" => $this->getRandomDate([1970, 2000]),
            "licence_number" => "",
            "licence_etat" => "",
            "groupes" => [],
            "cotisation_id" => null,
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
            "cotisation_id" => null,
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
        
    }

    public function initTresorie($froceCreation = true) {
        $this->_tresorie = $this->getUtil()->creationTresorie($froceCreation, false);
        $this->idTresorie = $this->_tresorie['id'];
    }

    public function initGroupe($froceCreation = true) {
        $this->_groupe = $this->getUtil()->creationGroupe();
        $this->idGroupe = $this->_groupe['id'];
    }

    public function initCotisation($froceCreation = true) {
        $this->_cotisation = $this->getUtil()->creationCotisation();
        $this->idCotisation = $this->_cotisation['id'];
    }

    //************************* COTISATION ********************************//

    const URL_COTISATIONS = "cotisation";

    public function getUrlGetCotisation($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_COTISATIONS;
    }

    public function getUrlAddCotisation($adherentId, $cotisationId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_COTISATIONS . "/" . $cotisationId;
    }

    private function addCotisation($adherentId, $cotisationId, $statusCodeExpected = null) {
        $request = $this->getClient()->post($this->getUrlAddCotisation($adherentId, $cotisationId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function removeCotisation($adherentId, $cotisationId, $statusCodeExpected = null) {
        $request = $this->getClient()->delete($this->getUrlAddCotisation($adherentId, $cotisationId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    private function getCotisation($adherentId, $statusCodeExpected = null) {
        $request = $this->getClient()->get($this->getUrlGetCotisation($adherentId), null, null);
        return $this->send($request, $statusCodeExpected);
    }

    public function testAddCotisation() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initCotisation();

        $this->logInfo("Creating new adherent", __METHOD__);
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created", __METHOD__);

        $this->logInfo("Linking Adherent[$adherentId] with Cotisation[$this->idCotisation].", __METHOD__);
        $this->addCotisation($adherentId, $this->idCotisation, Response::HTTP_CREATED);
        $this->logInfo("Link done", __METHOD__);

        $this->logInfo("Checking Link", __METHOD__);
        $response = $this->getCotisation($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        if ($dataResponse == $this->idCotisation) {
            $this->assertTrue(true, "Cotisation $this->idCotisation trouvee");
        } else {
            $this->assertTrue(false, "Cotisation $this->idCotisation non trouvee");
        }
    }

    public function testRemoveCotisation() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initCotisation();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $cotisationOK = $this->_cotisation;

        $response = $this->addCotisation($adherentId, $cotisationOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Cotisation added");

        $response = $this->removeCotisation($adherentId, $cotisationOK['id'], Response::HTTP_NO_CONTENT);
        $this->logInfo("Cotisation added");

        $response = $this->getCotisation($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

    //************************* GROUPE ********************************//

    const URL_GROUPES = "groupes";

    public function getUrlGetGroupes($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_GROUPES;
    }

    public function getUrlAddGroupe($adherentId, $groupeId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_GROUPES . "/" . $groupeId;
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
        $this->logDebug("======= START =========", __METHOD__);
        $this->initGroupe();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $this->addGroupe($adherentId, $this->idGroupe, Response::HTTP_CREATED);

        $response = $this->getGroupes($adherentId, Response::HTTP_ACCEPTED);
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
        $this->logDebug("======= START =========", __METHOD__);
        $this->initGroupe();

        $this->logInfo("Creating new Adherent" , __METHOD__);
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created", __METHOD__);

        $maxEntities = 2;
        for ($i = 0; $i < $maxEntities; $i++) {
            $this->logInfo("Creating new Groupe.", __METHOD__);
            $entity = $this->getUtil()->creationGroupe(true);
            $this->logInfo("Linking Adherent[$adherentId] with groupe[".$entity['id']."]" , __METHOD__);
            $this->addGroupe($adherentId, $entity ['id'], Response::HTTP_CREATED);
            $this->logInfo("Link done.", __METHOD__);
        }

        $this->logInfo("Checking Link.", __METHOD__);
        $response = $this->getGroupes($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        var_dump($dataResponse);
        $this->assertEquals($maxEntities, sizeof($dataResponse));
        $this->logInfo("Check OK", __METHOD__);
    }

    public function testAdd2GroupesIdentique() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initGroupe();

        $this->logInfo("Creating new Adherent" , __METHOD__);
        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created", __METHOD__);

        $entityOK = $this->_groupe;

        $this->logInfo("Linking Adherent[$adherentId] with groupe[".$entityOK['id']."]" , __METHOD__);
        $this->addGroupe($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Link done.", __METHOD__);

        $this->logInfo("Linking Adherent[$adherentId] with groupe[".$entityOK['id']."]" , __METHOD__);
        $this->addGroupe($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Link done.", __METHOD__);

        $this->logInfo("Checking Link", __METHOD__);
        $response = $this->getGroupes($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
        $this->logInfo("Checking OK", __METHOD__);
    }

    public function testRemoveGroupes() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initGroupe();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created", __METHOD__);

        $entityOK = $this->_groupe;

        $this->addGroupe($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Groupe added", __METHOD__);

        $this->removeGroupe($adherentId, $entityOK['id'], Response::HTTP_NO_CONTENT);
        $this->logInfo("Groupe added", __METHOD__);

        $response = $this->getGroupes($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

    //************************* TRESORIE ********************************//

    const URL_TRESORIES = "tresories";

    public function getUrlGetTresories($adherentId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_TRESORIES;
    }

    public function getUrlAddTresorie($adherentId, $tresorieId) {
        return self::URL_BACK . $this->getApiName() . "/" . $adherentId . "/" . $this::URL_TRESORIES .  "/" .$tresorieId;
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
        $this->logDebug("======= START =========", __METHOD__);
        $this->initTresorie();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created", __METHOD__);

        $this->logInfo("Adding tresorie id: " . $this->idTresorie, __METHOD__);
        $this->addTresorie($adherentId, $this->idTresorie, Response::HTTP_CREATED);
        $this->logInfo("Tresorie added.", __METHOD__);

        $response = $this->getTresories($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse as $tresorie) {
            if ($tresorie == $this->idTresorie) {
                $found = true;
                $this->assertTrue($found, "Tresorie trouvée", __METHOD__);
                break;
            }
        }
        $this->assertTrue($found, "Tresorie non trouvée", __METHOD__);
    }

    public function testGetTresories() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initTresorie();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $maxEntities = 2;
        for ($i = 0; $i < $maxEntities; $i++) {
            $this->logInfo("Adding Tresorie $i");
            $entity = $this->getUtil()->creationTresorie();
            $this->addTresorie($adherentId, $entity ['id'], Response::HTTP_CREATED);
        }

        $response = $this->getTresories($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals($maxEntities, sizeof($dataResponse));
    }

    public function testAdd2TresoriesIdentique() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initTresorie();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_tresorie;

        $this->addTresorie($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Tresorie added");

        $this->addTresorie($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Tresorie added");

        $response = $this->getTresories($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse));
    }

    public function testRemoveTresories() {
        $this->logDebug("======= START =========", __METHOD__);
        $this->initTresorie();

        $adherent = $this->testPost();
        $adherentId = $adherent['id'];
        $this->logInfo("Adherent $adherentId was created");

        $entityOK = $this->_tresorie;

        $this->addTresorie($adherentId, $entityOK['id'], Response::HTTP_CREATED);
        $this->logInfo("Tresorie added");

        $this->removeTresorie($adherentId, $entityOK['id'], Response::HTTP_NO_CONTENT);
        $this->logInfo("Tresorie added");

        $response = $this->getTresories($adherentId, Response::HTTP_ACCEPTED);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(0, sizeof($dataResponse));
    }

}
