<?php
namespace Controller\Cotisation;

use Controller\AbstractRtlqCrudTest;
use Controller\MyUtilClassTest;

class CotisationControllerTest extends AbstractRtlqCrudTest {

        private $idSaison;
        private $idCategorie;

        protected function getApiName() {
		return '/api/cotisations'; 
	}
	
        
	protected function getDataForPost() {
		$data = array (
				"description" => "Cotisation_" .  time(),
                    		"cotisation" => 200,
                                "repartitionCheque" => "100|100",
				"active" => false,
                    		"saison_id" => $this->idSaison,
                                "categorie_id" => $this->idCategorie                    
		);
		return $data;
	}
	
	protected function getDataForPut() {
		$data = array (
				"description" => "Cotisation_" .  time(),
                    		"cotisation" => 250,
                                "repartitionCheque" => "100|100|50",
				"active" => false,
                    		"saison_id" => $this->idSaison,
                                "categorie_id" => $this->idCategorie                    
		);
		return $data;
	}
	
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('description', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('repartitionCheque', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('saison_id', $dataResponse, $data);
                $this->assertArrayHasKeyNotNull('categorie_id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('active', $dataResponse, $data);
	}

        protected function assertPreConditions() {
            parent::assertPreConditions();
            $this->idSaison = $this->creationSaison();
            $this->idCategorie = $this->creationCategorie();               
        }

}
