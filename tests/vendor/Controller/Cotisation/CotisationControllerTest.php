<?php
namespace Controller\Cotisation;

use Controller\AbstractRtlqCrudTest;

class CotisationControllerTest extends AbstractRtlqCrudTest {

        private $idSaison;
        private $idCategorie;

        public function getApiName() {
		return '/api/cotisations'; 
	}

	public function getDataForPost() {
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
	
	public function getDataForPut() {
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
            $this->init();
        }
        
        public  function init() {
            $this->idSaison = $this->getUtil()->creationSaison()['id'];
            $this->idCategorie = $this->getUtil()->creationCategorie()['id'];               
        }

}
