<?php

namespace Controller\Tresorie;

use Controller\AbstractRtlqCrudTest;
use Guzzle\Http\Client;
use RoutanglangquanBundle\Controller\Api\Tresorie\TresorieController;

class TresoriesControllerTest extends AbstractRtlqCrudTest {

    private $idSaison;
    private $idCategorie;
    private $idEtat;
    private $idAdherent;
    private $pathGetByUser = "/by-user-";

    public function getApiName() {
        return '/api/tresorie/tresories';
    }

    public function getDataForPost() {
        $data = array(
            "description" => "Description" . time(),
            "adherent_name" => "Adherent" . time(),
            "montant" => rand(0, 999),
            "responsable" => "Responsable" . time(),
            "numero_cheque" => rand(1, 999999),
            "date_creation" => $this->getRandomDate(),
            "cheque" => false,
            "etat_id" => $this->idEtat,
            "saison_id" => $this->idSaison,
            "categorie_id" => $this->idCategorie,
            "adherent_id" => $this->idAdherent
        );
        return $data;
    }

    public function getDataForPut() {
        $data = array(
            "description" => "DescriptionPut" . time(),
            "adherent_name" => "AdherentPut" . time(),
            "montant" => rand(0, 999),
            "responsable" => "ResponsablePut" . time(),
            "numero_cheque" => rand(1, 999999),
            "date_creation" => $this->getRandomDate(),
            "cheque" => true,
            "etat_id" => $this->idEtat,
            "saison_id" => $this->idSaison,
            "categorie_id" => $this->idCategorie,
            "adherent_id" => $this->idAdherent
        );
        return $data;
    }

    protected function assertDataForPost($data, $dataResponse) {
        $this->assertArrayHasKeyNotNull('description', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('adherent_name', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('montant', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('responsable', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('numero_cheque', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('date_creation', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('cheque', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('etat_id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('saison_id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('categorie_id', $dataResponse, $data);
        $this->assertArrayHasKeyNotNull('adherent_id', $dataResponse, $data);
    }

    protected function assertPreConditions() {
        parent::assertPreConditions();
        $this->init();
    }

    public function init($withAdherent=true) {
        $this->idSaison = $this->getUtil()->creationSaison()['id'];

        $this->idCategorie = $this->getUtil()->creationCategorie()['id'];

        $this->idEtat = $this->getUtil()->creationEtat()['id'];

        if ($withAdherent) {
            $this->idAdherent = $this->getUtil()->creationAdherent()['id'];        
        }
    }

    public function testGetByUser() {
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName() . "/" . $this->pathGetByUser . $this->data->adherent, null, null);
        $response = $this->send($request, 201, json_encode($data));
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);

        $this->assertDataForPost($data, $dataResponse);
        return $dataResponse;
    }

}
