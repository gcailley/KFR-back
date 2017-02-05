<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

use Controller\Saison\SaisonsControllerTest;
use Controller\Tresorie\TresoriesCategorieControllerTest;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

/**
 * Description of newPHPClass
 *
 * @author GREGORY
 */
class MyUtilClassTest {

    public function creationSaison() {
        print_r("creationSaison");
        $saisonTest = new SaisonsControllerTest();
        $data = $saisonTest->getDataForPost();
        $request = $this->getClient()->post(self::URL_BACK . $saisonTest->getApiName(), null, json_encode($data));
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $idSaison = $dataResponse['id'];
        $this->assertNotNull($idSaison);
        return $idSaison;
    }

    public function creationCategorie() {
        $categorieTest = new TresoriesCategorieControllerTest();
        $data = $categorieTest->getDataForPost();
        $request = $this->getClient()->post(self::URL_BACK . $categorieTest->getApiName(), null, json_encode($data));
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $idCategorie = $dataResponse['id'];
        $this->assertNotNull($idCategorie);
        return $idCategorie;
    }
}
