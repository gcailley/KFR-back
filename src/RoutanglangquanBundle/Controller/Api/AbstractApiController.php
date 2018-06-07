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

abstract class AbstractApiController extends AbstractController {

    protected $builder;

    abstract protected function getName();

    abstract protected function getNameType();

    abstract protected function getBuilder();

    abstract public function newDto();

    public function __construct() {
        $this->builder = $this->getBuilder();
    }

   
    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    abstract public function getByIdAction(Request $request, $id);
    /**
     * @Route("")
     * @Method("GET")
     */
    abstract public function getAllAction(Request $request, $response);

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

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     * 
     * @return RtlqValidator
     */
    public function getValidator() {
        return new RtlqValidator();
    }

}
