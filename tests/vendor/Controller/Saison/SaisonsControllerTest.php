<?php

namespace Controller\Saison;

use Controller\AbstractRtlqCrudTest;
use function GuzzleHttp\json_encode;

class SaisonsControllerTest extends AbstractRtlqCrudTest {
	
	public function getApiName() {
		return '/api/saisons'; 
	}
	
	public function getDataForPost() {
		$data = array (
				"nom" => "Saison_" .  time(),
				"date_debut" =>$this->getRandomDate([1970,2000]),
				"date_fin" =>$this->getRandomDate([2001,2020]),
				"active" => false
		);
		return $data;
	}
	
	public function getDataForPut() {
		$data = array (
				"nom" => "SaisonPut_" .  time(),
				"date_debut" =>$this->getRandomDate([1970,2000]),
				"date_fin" =>$this->getRandomDate([2001,2020]),
				"active" => true
		);
		return $data;
	}
	
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('date_debut', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('date_fin', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('active', $dataResponse, $data);
	}

	public function testPostSaisonEnDouble() {
		$data = $this->getDataForPost ();
	
		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $data ) );
		$response = $request->send ();
		$this->assertEquals ( 201, $response->getStatusCode () );

		//ecriture avec le meme nom de saison
		$dataTwo = $this->getDataForPost ();
		$dataTwo["nom"]=$data["nom"];
		
		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $dataTwo ) );
		$response = $this->sendWithAssert($request, 500);
	}	

	public function testPostSaisonIncoherenceDate() {
		$data = $this->getDataForPost ();
		$data["date_debut"] = $this->getRandomDate([2005,2010]);
		$data["date_fin"] = $this->getRandomDate([2000,2004]);
	
		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $data ) );
		$response = $this->sendWithAssert($request, 400);
	}
	
	
}
