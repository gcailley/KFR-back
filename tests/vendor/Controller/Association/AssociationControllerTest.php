<?php
namespace Controller\Association;

use Controller\AbstractRtlqCrudTest;
use Controller\MyUtilClassTest;

class AssociationControllerTest extends AbstractRtlqCrudTest {


        public function getApiName() {
		return '/api/associations'; 
	}
	
        
	public function getDataForPost() {
		$data = array (
				"nom" => "Association_" .  time(),
                    		"date_creation" => $this->getRandomDate([1970,2000]),
				"active" => false,
                    		"siege_social" => $this->getRandomText(),
                                "email" => $this->getRandomText(10) . "@" . $this->getRandomText(5)."fr"   
		);                
		return $data;
	}
	
	public function getDataForPut() {
		$data = array (
				"nom" => "Association_" .  time(),
                    		"date_creation" => $this->getRandomDate([1970,2000]),
				"active" => false,
                    		"siege_social" => $this->getRandomText(),
                                "email" => $this->getRandomText(10) . "@" . $this->getRandomText(5)."fr"   
		);
		return $data;
	}
	
	protected function assertDataForPost($data, $dataResponse) {
		$this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('nom', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('siege_social', $dataResponse, $data);
                $this->assertArrayHasKeyNotNull('email', $dataResponse, $data);
		$this->assertArrayHasKeyNotNull('active', $dataResponse, $data);
	}

        protected function assertPreConditions() {
            parent::assertPreConditions();
        }

}
