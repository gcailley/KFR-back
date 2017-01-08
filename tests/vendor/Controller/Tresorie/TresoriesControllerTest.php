<?php

namespace Controller\Tresorie;

use Controller\AbstractRtlqCrudTest;
use Guzzle\Http\Client;
use RoutanglangquanBundle\Controller\Api\Tresorie\TresorieController;

class TresoriesControllerTest extends AbstractRtlqCrudTest {
	
	protected function getApiName() {
		return '/api/tresorie/tresories'; 
	}
	
	protected function getDataForPost() {
		$data = array (
				"description" => "Description" .  time(),
				"adherent" =>"Adherent" . time(),
				"montant" =>rand ( 0, 999 ),
				"responsable" =>"Responsable". time(),
				"numero_cheque" =>rand ( 1, 999999 ),
				"date_creation" =>$this->getRandomDate(),
				"cheque" =>false,
				"etat_id" =>1,
				"saison_id" =>1,
				"categorie_id" =>1
		);
		return $data;
	}
	
	protected function getDataForPut() {
		$data = array (
				"description" => "DescriptionPut" .  time(),
				"adherent" =>"AdherentPut" . time(),
				"montant" =>rand ( 0, 999 ),
				"responsable" =>"ResponsablePut". time(),
				"numero_cheque" =>rand ( 1, 999999 ),
				"date_creation" =>$this->getRandomDate(),
				"cheque" =>true,
				"etat_id" =>1,
				"saison_id" =>1,
				"categorie_id" =>1
		);
		return $data;
	}
	
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('description', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('adherent', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('montant', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('responsable', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('numero_cheque', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('cheque', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('etat_id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('saison_id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('categorie_id', $dataResponse, $data);
	}

	

}
