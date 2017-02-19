<?php

namespace Controller\Tresorie;

use Controller\AbstractRtlqCrudTest;
use Guzzle\Http\Client;
use RoutanglangquanBundle\Controller\Api\Tresorie\TresorieController;

class TresoriesCategorieControllerTest extends AbstractRtlqCrudTest {
	
	public function getApiName() {
		return '/api/tresorie/categories'; 
	}
	
	public function getDataForPost() {
		$data = array (
			"value" => "testCategorie".  time()
		);
		return $data;
	}
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('value', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
	}

	

}
