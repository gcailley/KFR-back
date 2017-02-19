<?php

namespace Controller\Tresorie;

use Controller\AbstractRtlqCrudTest;
use Guzzle\Http\Client;
use RoutanglangquanBundle\Controller\Api\Tresorie\TresorieController;

class TresoriesEtatControllerTest extends AbstractRtlqCrudTest {
	
	public function getApiName() {
		return '/api/tresorie/etats'; 
	}
	
	public function getDataForPost() {
		$data = array (
				"value" => "testEtat". time()
		);
		return $data;
	}
	
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('value', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
	}

	

}
