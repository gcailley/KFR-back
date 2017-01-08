<?php

namespace Controller\Cotisation;

use Controller\AbstractRtlqCrudTest;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class CotisationControllerTest extends AbstractRtlqCrudTest {

        private $idSaison ;
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

//                $this->logDebug("creation saison pour le test", true);
                $saisonTest = new \Controller\Saison\SaisonsControllerTest();
                $data = $saisonTest->getDataForPost();
                $request = $this->getClient ()->post ( self::URL_BACK . $saisonTest->getApiName(), null, json_encode($data) );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
                $this->idSaison = $dataResponse['id'];
                $this->assertNotNull ( $this->idSaison );
                
//                $this->logDebug("creation categorie pour le test", true);
                $categorieTest = new \Controller\Tresorie\TresoriesCategorieControllerTest();
                $data = $categorieTest->getDataForPost();
                $request = $this->getClient ()->post ( self::URL_BACK . $categorieTest->getApiName(), null, json_encode($data) );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
                $this->idCategorie = $dataResponse['id'];
                $this->assertNotNull ( $this->idCategorie );
        }

}
