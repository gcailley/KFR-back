<?php

namespace Controller;

use Controller\Association\AdherentControllerTest;
use Controller\Association\GroupeControllerTest;
use Controller\Cotisation\CotisationControllerTest;
use Controller\Saison\SaisonsControllerTest;
use Controller\Tresorie\TresoriesCategorieControllerTest;
use Controller\Tresorie\TresoriesControllerTest;
use Controller\Tresorie\TresoriesEtatControllerTest;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Message\RequestInterface;
use Symfony\Component\Form\FormConfigInterface;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use function random_int;

abstract class AbstractRtlqCrudTest extends \PHPUnit_Framework_TestCase {

    const URL_BACK = "http://localhost/kfr-back/web/app_dev.php";

    private $util;
    private $debug;
    private $client;

    /**
     * Creates a new button from a form configuration.
     *
     * @param FormConfigInterface $config
     *        	The button's configuration
     */
    public function __construct() {
        $this->client = new Client(self::URL_BACK, array(
            'content-type' => 'application/json'
        ));
        $this->util = new CreatToolsTest();
        
        $this->debug = in_array('-vvv', $_SERVER['argv'], true);
        $this->info = in_array('-vv', $_SERVER['argv'], true);
        $this->error = in_array('-v', $_SERVER['argv'], true);
        
    }

    public function init() {
        
    }

    public function getUtil() {
        return $this->util;
    }

    abstract public function getApiName();

    abstract public function getDataForPost();

    abstract protected function assertDataForPost($data, $dataResponse);
    

    public function getDataForPut() {
        return $this->getDataForPost();
    }

    protected function assertDataForPut($data, $dataResponse) {
        return $this->assertDataForPost($data, $dataResponse);
    }

    protected function assertDataForGet($data, $dataResponse) {
        return $this->assertDataForPost($data, $dataResponse);
    }
    
    
    public function testPost() {
        $data = $this->getDataForPost();

        $request = $this->getClient()->post(self::URL_BACK . $this->getApiName(), null, json_encode($data));
        $response = $this->send($request, 201, json_encode($data));
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);

        $this->assertDataForPost($data, $dataResponse);
        return $dataResponse;
    }

    public function testGetAll() {
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName(), null, null);
        $response = $this->send($request, 201, json_encode($data));

        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);

        $size = sizeof($dataResponse) - 1;

        $this->assertDataForGet(array(), $dataResponse [$size]);
        return $dataResponse;
    }

    public function testGetLast() {
        $this->logInfo(__METHOD__, true);
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName(), null, null);
        $response = $this->send($request, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
        $size = sizeof($dataResponse) - 1;

        $requestOne = $this->getClient()->get(self::URL_BACK . $this->getApiName() . '/' . $dataResponse [$size] ['id'], null, null);
        $responseOne = $this->send($requestOne, 201);
        $dataResponseOne = json_decode($responseOne->getBody(true), true);

        $this->assertNotNull($dataResponseOne);
        $this->assertDataForPost(array(), $dataResponse [$size]);
    }

    public function testPut() {
        $dataPost = $this->getDataForPost();
        $dataPut = $this->getDataForPut();

        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName(), null, null);
        $response = $this->send($request, 201);
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull("dataResponse null", $dataResponse);


        $idUpdate = $dataResponse [0] ['id'];
        $request = $this->getClient()->put(self::URL_BACK . $this->getApiName() . '/' . $idUpdate, null, json_encode($dataPut));
        $response = $this->send($request, 201, json_encode($dataPut));

        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
        $this->assertDataForPut($dataPut, $dataResponse);
    }

    public function testPutAvecChampUnknown() {
        $this->logInfo(__METHOD__, true);
        $dataPut = $this->getDataForPut();

        $dataPut ['blabclbqsdpqjdpeoq'] = "qsdq";

        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName(), null, null);
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);


        $idUpdate = $dataResponse[0] ['id'];
        $request = $this->getClient()->put(self::URL_BACK . $this->getApiName() . '/' . $idUpdate, null, json_encode($dataPut));
        $response = $this->send($request, 201, json_encode($dataPut));

        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
        $this->assertDataForPut($dataPut, $dataResponse);
    }

    public function testPutNotFound() {
        $dataPut = $this->getDataForPut();
        $idUpdate = 0;
        $request = $this->getClient()->put(self::URL_BACK . $this->getApiName() . '/' . $idUpdate, null, json_encode($dataPut));
        $response = $this->send($request, 404,  json_encode($dataPut));
    }

    public function testDeleteLast() {
        $request = $this->getClient()->get(self::URL_BACK . $this->getApiName(), null, null);
        $response = $request->send();
        $dataResponse = json_decode($response->getBody(true), true);
        $this->assertNotNull($dataResponse);
        $size = sizeof($dataResponse) - 1;

        $requestOne = $this->getClient()->delete(self::URL_BACK . $this->getApiName() . '/' . $dataResponse [$size] ['id'], null, null);
        $responseOne = $this->send($requestOne, 201);
        $dataResponseOne = json_decode($responseOne->getBody(true), true);
        $this->assertNull($dataResponseOne);
        
    }

    public function testDeleteNotFound() {
        $request = $this->getClient()->delete(self::URL_BACK . $this->getApiName() . '/0', null, null);
        $this->send($request, 404);
    }

    public function getClient() {
        return $this->client;
    }

    protected function assertArrayHasKeyNotNull($name, $arrayResult, $arrayInitial = array()) {
        $this->assertArrayHasKey($name, $arrayResult, "$name n'est pas dans le tableau de resultats");
        $this->assertNotNull($arrayResult [$name], "$name est NULL et ne devrait pas");
        if (array_key_exists($name, $arrayInitial)) {
            $this->assertEquals(trim($arrayInitial [$name]), $arrayResult [$name], "$name n'a pas la même valeur AVANT/APRES stockage en base");
        }
    }

    protected function assertArrayHasKeyNull($name, $arrayResult, $arrayInitial = array()) {
        if (array_key_exists($name, $arrayResult)) {
            $this->assertNull($arrayResult[$name], $name . " n'est pas null");
        }
    }

    protected function getRandomText($length = null, $lengthMin = null, $lengthMax = null) {

        if ($lengthMin == null) {
            $lengthMin = random_int(1, $lengthMax == null ? 50 : $lengthMax);
        }
        if ($lengthMax == null) {
            $lengthMax = random_int($lengthMin + 1, 255);
        }
        if ($length == null) {
            $length = random_int($lengthMin, $lengthMax);
        }

        $text = array();
        $alphabe = [" ", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];

        for ($i = 0; $i < $length; $i++) {
            $text[] = $alphabe[random_int(0, sizeof($alphabe))];
        }

        return implode("", $text);
    }

    protected function getRandomDate($yearsRange = [1970, 2020], $monthsRange = [1, 12], $daysRange = [1, 28]) {

        $month = rand($monthsRange[0], $monthsRange[1]);
        $month = $month < 10 ? "0" . $month : $month;
        $day = rand($daysRange[0], $daysRange[1]);
        $day = $day < 10 ? "0" . $day : $day;
        return rand($yearsRange[0], $yearsRange[1]) . "-" . $month . "-" . $day;
    }

    protected function getRandomEmail() {
        return str_replace(" ", "", $this->getRandomText(5) . "@" . $this->getRandomText(4) . ".fr");
    }

    protected function getRandomNumero($length = null) {
        $text = array();
        for ($i = 0; $i < $length; $i++) {
            $text[] = rand(0, 9);
        }
        return implode("", $text);
    }

    protected function getRandomTelephone() {
        return "0" . $this->getRandomNumero(9);
    }

    public function send(RequestInterface $request, $statusCodeExpected, $data = null) {
        try {
            $response = $request->send();
        } catch (RequestException $e) {
            $response = $e->getRequest()->getResponse();
            if ($response->getStatusCode() == 500 && $response->getStatusCode() !=  $statusCodeExpected) {
                $this->logError('[' . $request->getMethod() . "] - " . $request->getUrl());
                $this->logError($data);
                $this->logError($response->getHeader("x-debug-error"));
                $this->assertTrue(false, $response->getHeader("x-debug-error"));
            }
        }
        if ($statusCodeExpected != null) {
            $this->assertEquals($statusCodeExpected, $response->getStatusCode(), 'request : [' . $request->getMethod() . "] - " . $request->getUrl());
        }
        return $response;
    }

    /* Add Warnings */

    protected function addWarning($msg, Exception $previous = null) {
        $add_warning = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_Warning($msg, 0, $previous);
        $add_warning->addWarning($this, $msg, time());
        $this->setTestResultObject($add_warning);
    }

    /* Add errors */

    protected function addError($msg, Exception $previous = null) {
        $add_error = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_AssertionFailedError($msg, 0, $previous);
        $add_error->addError($this, $msg, time());
        $this->setTestResultObject($add_error);
    }

    /* Add failures */

    protected function addFailure($msg, Exception $previous = null) {
        $add_failure = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_AssertionFailedError($msg, 0, $previous);
        $add_failure->addFailure($this, $msg, time());
        $this->setTestResultObject($add_failure);
    }

    public function logDebug($myDebugVar, $newligne = true) {
        if ($this->debug) {
            fwrite(STDOUT, print_r("   DEBUG > " . $myDebugVar, TRUE));
            if ($newligne)
                fwrite(STDOUT, print_r("\n", TRUE));
        }
    }

    public function logInfo($myDebugVar, $newligne = true) {
        if ($this->info || $this->debug) {
            fwrite(STDOUT, print_r("INFO > " . $myDebugVar, TRUE));
            if ($newligne)
                fwrite(STDOUT, print_r("\n", TRUE));
        }
    }

    public function logError($myDebugVar) {
        if ($this->error || $this->info || $this->debug) {
            fwrite(STDERR, print_r("ERROR > " . $myDebugVar . "\n", TRUE));
        }
    }

}

/**
 * Description of newPHPClass
 *
 * @author GREGORY
 */
class CreatToolsTest {

    public function creationSaison() {
        $testEntity = new SaisonsControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationCategorie() {
        $testEntity = new TresoriesCategorieControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationEtat() {
        $testEntity = new TresoriesEtatControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationCotisation($data = array()) {
        $testEntity = new CotisationControllerTest();
        return $this->sendAndExtract($testEntity, $data);
    }

    public function creationAdherent() {
        $testEntity = new AdherentControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationGroupe() {
        $testEntity = new GroupeControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    public function creationTresorie() {
        $testEntity = new TresoriesControllerTest();
        return $this->sendAndExtract($testEntity);
    }

    private function sendAndExtract(AbstractRtlqCrudTest $testObject, $data2 = array(), $params = null) {
        $testObject->init();
        $data = $testObject->getDataForPost();
        $data = array_replace($data, $data2);

        $testObject->logDebug("Creating " . $testObject->getApiName());
        $testObject->logDebug(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName());
        $testObject->logDebug(json_encode($data));

        $request = $testObject->getClient()->post(AbstractRtlqCrudTest::URL_BACK . $testObject->getApiName(), $params, json_encode($data));
        $response = $testObject->send($request);

        $dataResponse = json_decode($response->getBody(true), true);
        $id = $dataResponse['id'];
        $testObject->assertNotNull($id);

        $testObject->logDebug("entity $id has been created");
        $testObject->logDebug("--------------------- ");

        return $dataResponse;
    }

}
