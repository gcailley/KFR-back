<?php

namespace RoutanglangquanBundle\Controller\Api;

use GuzzleHttp\json_encode;
use RoutanglangquanBundle\Form\Validator\RtlqValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractApiController extends Controller {

    protected $builder;

    abstract protected function getName();

    abstract protected function getNameType();

    abstract protected function getBuilder();

    abstract protected function newDto();

    public function __construct() {
        $this->builder = $this->getBuilder();
    }

    protected function newResponse($data, $code) {
        $response = new Response($data, $code);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    
    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    abstract public function getByIdAction($id);
    /**
     * @Route("")
     * @Method("GET")
     */
    abstract public function getAllAction(Request $request);

    /**
     * @Route("")
     * @Method("POST")
     */
    abstract public function createAction(Request $request);

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    abstract public function deleteByIdAction($id);
   
    public function createInvalideBean($errors = array()) {
        return new HttpException(Response::HTTP_BAD_REQUEST, implode($errors));
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     * 
     * @return RtlqValidator
     */
    public function getValidator() {
        return new RtlqValidator();
    }

}
