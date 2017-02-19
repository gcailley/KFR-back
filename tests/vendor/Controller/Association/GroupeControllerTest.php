<?php

namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;

class GroupeControllerTest extends AbstractRtlqCrudTest {

    public function getApiName() {
        return '/api/association/groupes';
    }

    public function getDataForPost() {
        $data = array(
            "nom" => "Groupe_" . time()
        );
        return $data;
    }

    public function getDataForPut() {
        $data = array(
            "nom" => "Groupe_" . time()
        );
        return $data;
    }

    protected function assertDataForPost($data, $dataResponse) {
        $this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
    }

    protected function assertPreConditions() {
        parent::assertPreConditions();
        $this->init();
    }

    public function init() {
        
    }

}
