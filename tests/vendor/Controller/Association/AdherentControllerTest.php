<?php

namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;

class AdherentControllerTest extends AbstractRtlqCrudTest {

    private $idCotisation;
    private $idGroupe;
    
    const URL_COTISATIONS = "cotisations/";
    const URL_GROUPES = "groupes/";

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
            "groupes" => [],
            "cotisations" => []);

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
            "groupes" => [],
            "cotisations" => []);
        return $data;
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
    }

    protected function assertPreConditions() {
        parent::assertPreConditions();
        $this->init();
    }
    
    public function init() {
        $this->idCotisation = $this->getUtil()->creationCotisation();
        $this->idGroupe = $this->getUtil()->creationGroupe();
    }

    public function testAddCotisation() {
        $data = $this->getDataForPost();
        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $adherentId= $dataResponse['id'];
        $this->logInfo("Adherent $adherentId was created");
        
        $urlAddCotisation = self::URL_BACK . $this->getApiName() ."/".$adherentId."/".$this::URL_COTISATIONS.$this->idCotisation;
        $request = $this->getClient()->post($urlAddCotisation , null, null);
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse["cotisations"] as $cotisation) {
            if ($cotisation == $this->idCotisation) {
                $found=true;
                break;
            }
        }
        $this->assertTrue($found, "Cotisation non trouve");
    }
    
    
    
    public function testAddGroupe() {
        $data = $this->getDataForPost();
        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $adherentId= $dataResponse['id'];
        $this->logInfo("Adherent $adherentId was created");
        
        $urlAddGroupe = self::URL_BACK . $this->getApiName() ."/".$adherentId."/".$this::URL_GROUPES.$this->idGroupe;
        $request = $this->getClient()->post($urlAddGroupe , null, null);
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $found = false;
        foreach ($dataResponse["groupes"] as $groupe) {
            if ($groupe == $this->idGroupe) {
                $found=true;
                break;
            }
        }
        $this->assertTrue($found, "Groupe non trouve");
    }
}
