<?php

namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;
use Controller\MyUtilClassTest;

class AdherentControllerTest extends AbstractRtlqCrudTest {

    protected function getApiName() {
        return '/api/association/adherent';
    }

    protected function getDataForPost() {
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

    protected function getDataForPut() {
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

    protected function assertDataForPost($data, $dataResponse) {
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
    }

}
