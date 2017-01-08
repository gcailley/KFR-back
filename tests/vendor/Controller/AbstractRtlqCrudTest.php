<?php

namespace Controller;

use Guzzle\Http\Client;
use Guzzle\Tests\Http\Exception\ExceptionTest;
use Guzzle\Http\Exception\RequestException;

abstract class AbstractRtlqCrudTest extends \PHPUnit_Framework_TestCase {
	const URL_BACK = "http://localhost/kfr-back/web/app_dev.php";
	private $client;
	
    protected function setUp()
    {
//        $this->logDebug("\nRunning :");
    }

    protected function assertPreConditions()
    {
//        $this->logDebug(__METHOD__);
    }


    protected function assertPostConditions()
    {
//        $this->logDebug(__METHOD__);
    }

    protected function tearDown()
    {
//        $this->logDebug("Result :");
    }

    public static function tearDownAfterClass()
    {
//        $this->logDebug(__METHOD__);
    }

	/**
	 * Creates a new button from a form configuration.
	 *
	 * @param FormConfigInterface $config
	 *        	The button's configuration
	 */
	public function __construct() {
		$this->client = new Client ( self::URL_BACK, array (
				'content-type' => 'application/json' 
		) );
	}
	abstract protected function getApiName();
	abstract protected function getDataForPost();
	abstract protected function assertDataForPost($data, $dataResponse);
	protected function getDataForPut() {
		return $this->getDataForPost ();
	}
	public function testPost() {
                $this->logDebug(__METHOD__,true);
		$data = $this->getDataForPost ();
     
                $this->logDebug( json_encode ( $data ));
		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $data ) );
		$response = $request->send ();
		$this->assertEquals ( 201, $response->getStatusCode () );
		
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		
		$this->assertDataForPost ( $data, $dataResponse );               
	}
	public function testPut() {
                $this->logDebug(__METHOD__,true);
		$dataPost = $this->getDataForPost ();
		$dataPut = $this->getDataForPut ();

                $request = $this->getClient ()->get ( self::URL_BACK . $this->getApiName (), null, null );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		
//		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $dataPost ) );
//		$response = $request->send ();
//		$this->assertEquals ( 201, $response->getStatusCode () );
//		$dataResponse = json_decode ( $response->getBody ( true ), true );
//		$this->assertNotNull ( $dataResponse );
//		$this->assertDataForPost ( $dataPost, $dataResponse );
		
		
                $idUpdate = $dataResponse ['id'];
		$request = $this->getClient ()->put ( self::URL_BACK . $this->getApiName () . '/' . $idUpdate, null, json_encode ( $dataPut ) );
		$response = $request->send ();
		$this->assertEquals ( 201, $response->getStatusCode () );
		
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		$this->assertDataForPost ( $dataPut, $dataResponse );

                $this->logDebug("Clean");
                $this->logDebug(self::URL_BACK . $this->getApiName () . '/' . $idUpdate);

		$requestOne = $this->getClient ()->delete ( self::URL_BACK . $this->getApiName () . '/' . $idUpdate, null, null );
		$responseOne = $requestOne->send ();
	}
	public function testPutAvecChampUnknown() {
		$this->logDebug(__METHOD__,true);
                $dataPost = $this->getDataForPost ();
		$dataPut = $this->getDataForPut ();
		
		$dataPut ['blabclbqsdpqjdpeoq'] = "qsdq";
		
//		$request = $this->getClient ()->post ( self::URL_BACK . $this->getApiName (), null, json_encode ( $dataPost ) );
//		$response = $request->send ();
//		$this->assertEquals ( 201, $response->getStatusCode () );
//		
//		$dataResponse = json_decode ( $response->getBody ( true ), true );
//		$this->assertNotNull ( $dataResponse );
//		$this->assertDataForPost ( $dataPost, $dataResponse );
//		
                $request = $this->getClient ()->get ( self::URL_BACK . $this->getApiName (), null, null );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		
                
		$idUpdate = $dataResponse ['id'];
		$request = $this->getClient ()->put ( self::URL_BACK . $this->getApiName () . '/' . $idUpdate, null, json_encode ( $dataPut ) );
		$response = $request->send ();
		$this->assertEquals ( 201, $response->getStatusCode () );
		
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		$this->assertDataForPost ( $dataPut, $dataResponse );
		
		$requestOne = $this->getClient ()->delete ( self::URL_BACK . $this->getApiName () . '/' . $idUpdate, null, null );
		$responseOne = $requestOne->send ();
	}
	public function testPutNotFound() {
		$this->logDebug(__METHOD__,true);
                $dataPut = $this->getDataForPut ();
		$idUpdate = 0;
		$request = $this->getClient ()->put ( self::URL_BACK . $this->getApiName () . '/' . $idUpdate, null, json_encode ( $dataPut ) );
		try {
			$response = $request->send ();
			$this->assertEquals ( 404, $response->getStatusCode () );
		} catch ( RequestException $e ) {
			$this->assertEquals ( 404, $e->getRequest ()->getResponse ()->getStatusCode () );
		}
	}
	public function testGetAll() {
		$this->logDebug(__METHOD__,true);
                $request = $this->getClient ()->get ( self::URL_BACK . $this->getApiName (), null, null );
		$response = $request->send ();
		$this->assertEquals ( 201, $response->getStatusCode () );
		
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		
		$size = sizeof ( $dataResponse ) - 1;
		
		$this->assertDataForPost ( array (), $dataResponse [$size] );
	}
	public function testGetLast() {
                $this->logDebug(__METHOD__,true);
                $request = $this->getClient ()->get ( self::URL_BACK . $this->getApiName (), null, null );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		$size = sizeof ( $dataResponse ) - 1;
		
		$requestOne = $this->getClient ()->get ( self::URL_BACK . $this->getApiName () . '/' . $dataResponse [$size] ['id'], null, null );
		$responseOne = $requestOne->send ();
		$dataResponseOne = json_decode ( $responseOne->getBody ( true ), true );
		
		$this->assertEquals ( 201, $responseOne->getStatusCode () );
		$this->assertNotNull ( $dataResponseOne );
		
		$this->assertDataForPost ( array (), $dataResponse [$size] );
	}
	public function testDeleteLast() {
                $this->logDebug(__METHOD__,true);
                $request = $this->getClient ()->get ( self::URL_BACK . $this->getApiName (), null, null );
		$response = $request->send ();
		$dataResponse = json_decode ( $response->getBody ( true ), true );
		$this->assertNotNull ( $dataResponse );
		$size = sizeof ( $dataResponse ) - 1;
		
		$requestOne = $this->getClient ()->delete ( self::URL_BACK . $this->getApiName () . '/' . $dataResponse [$size] ['id'], null, null );
		$responseOne = $requestOne->send ();
		$dataResponseOne = json_decode ( $responseOne->getBody ( true ), true );
		
		$this->assertEquals ( 201, $responseOne->getStatusCode () );
		$this->assertNull ( $dataResponseOne );
	}
	public function testDeleteNotFound() {
		$this->logDebug(__METHOD__,true);
                $requestOne = $this->getClient ()->delete ( self::URL_BACK . $this->getApiName () . '/0', null, null );
		try {
			$responseOne = $requestOne->send ();
			$this->assertEquals ( 404, $responseOne->getStatusCode () );
		} catch ( RequestException $e ) {
			$this->assertEquals ( 404, $e->getRequest ()->getResponse ()->getStatusCode () );
		}
	}
	protected function getClient() {
		return $this->client;
	}
	protected function assertArrayHasKeyNotNull($name, $arrayResult, $arrayInitial = array()) {
		$this->assertArrayHasKey ( $name, $arrayResult );
		$this->assertNotNull ( $arrayResult [$name] );
		if (array_key_exists ( $name, $arrayInitial )) {
			$this->assertEquals ( $arrayInitial [$name], $arrayResult [$name] );
		}
	}
	protected function getRandomDate($yearsRange=[1970,2020], $monthsRange=[1,12], $daysRange=[1,28]) {
		
		$month = rand ( $monthsRange[0], $monthsRange[1] );
		$month = $month < 10 ? "0" . $month : $month;
		$day = rand ( $daysRange[0], $daysRange[1] );
		$day = $day < 10 ? "0" . $day : $day;
		return rand ( $yearsRange[0], $yearsRange[1] ) . "-" . $month . "-" . $day;
	}
	protected function sendWithAssert($request, $statusCodeExpected){
		try {
			$response = $request->send();
			$this->assertEquals ( $statusCodeExpected, $response->getStatusCode () );
		} catch (RequestException $e) {
			$this->assertEquals ( $statusCodeExpected, $e->getRequest ()->getResponse ()->getStatusCode () );
			$response = $e->getRequest ()->getResponse ();
		}
		return $response;
	}
        
        
        
        
        
         /* Add Warnings */
    protected function addWarning($msg, Exception $previous = null)
    {
        $add_warning = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_Warning($msg, 0, $previous);
        $add_warning->addWarning($this, $msg, time());
        $this->setTestResultObject($add_warning);
    }

    /* Add errors */
    protected function addError($msg, Exception $previous = null)
    {
        $add_error = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_AssertionFailedError($msg, 0, $previous);
        $add_error->addError($this, $msg, time());
        $this->setTestResultObject($add_error);
    }

    /* Add failures */
    protected function addFailure($msg, Exception $previous = null)
    {
        $add_failure = $this->getTestResultObject();
        $msg = new PHPUnit_Framework_AssertionFailedError($msg, 0, $previous);
        $add_failure->addFailure($this, $msg, time());
        $this->setTestResultObject($add_failure);
    }
    protected function logDebug($myDebugVar, $newligne=false) {
//        fwrite(STDOUT, print_r($myDebugVar, TRUE));       
//        if($newligne) fwrite(STDOUT, print_r( "\n", TRUE));       
    }
    protected function logError($myDebugVar) {
        fwrite(STDERR, print_r($myDebugVar . "\n", TRUE));    
    }
  
}

