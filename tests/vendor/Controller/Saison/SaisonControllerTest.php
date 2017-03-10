<?php

namespace Controller\Saison;

use Controller\AbstractRtlqCrudTest;
use function GuzzleHttp\json_encode;

class SaisonControllerTest extends AbstractRtlqCrudTest {

    public function getApiName() {
        return '/api/saisons';
    }

    public function getDataForPost() {
        $data = array(
            "nom" => "Saison_" . time(),
            "date_debut" => $this->getRandomDate([1970, 2000]),
            "date_fin" => $this->getRandomDate([2001, 2020]),
            "active" => false
        );
        return $data;
    }

    public function getDataForPut() {
        $data = array(
            "nom" => "SaisonPut_" . time(),
            "date_debut" => $this->getRandomDate([1970, 2000]),
            "date_fin" => $this->getRandomDate([2001, 2020]),
            "active" => false
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
        $data = $this->getDataForPost();

        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $this->send($request, 201, json_encode($data));

        //ecriture avec le meme nom de saison
        $dataTwo = $this->getDataForPost();
        $dataTwo["nom"] = $data["nom"];

        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($dataTwo));
        $this->send($request, 500, json_encode($dataTwo));
    }

    public function testPostSaisonIncoherenceDate() {
        $data = $this->getDataForPost();
        $data["date_debut"] = $this->getRandomDate([2005, 2010]);
        $data["date_fin"] = $this->getRandomDate([2000, 2004]);

        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $this->send($request, 400, json_encode($data));
    }

    public function testSaisonActive() {
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName()."?active=true", null, null);
        $response = $this->send($request, 201, null);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
       
        foreach ($dataResponse  as $saison) {
            $this->assertTrue($saison["active"]," Saison ".$saison["id"]. " n'est pas active.");
        } 
    }

    public function testSaisonNonActive() {
        $data = $this->getDataForPost();
        $data["date_debut"] = $this->getRandomDate([2005, 2010]);
        $data["date_fin"] = $this->getRandomDate([2000, 2004]);

        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName()."?active=false", null, null);
        $response = $this->send($request, 201, null);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
        
        foreach ($dataResponse  as $saison) {
            $this->assertFalse($saison["active"]," Saison ".$saison["id"]. " est active.");
        } 
    }

    
    
    
    public function testPostSaisonActive() {
        //ecriture une saison active
        $data = $this->getDataForPost();
        $data["active"] = true;
        
        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $this->send($request, 201, json_encode($dataTwo));
        
        //test le nombre de saison active
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName()."?active=true", null, null);
        $response = $this->send($request, 201, null);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertEquals(1, sizeof($dataResponse), "Il n'y a pas qu'une saison active.");
        $data["id"]=$dataResponse[0]["id"];
        $this->assertDataForPost($data, $dataResponse[0]);
    }
}
