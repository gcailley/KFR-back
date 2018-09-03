<?php

namespace App\Controller\Api;

use GuzzleHttp\json_encode;
use App\Form\Validator\RtlqValidator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class AbstractApiController extends AbstractRtlqController {

    protected $builder;

    abstract protected function getName();

    abstract protected function getNameType();

    abstract protected function getBuilder();

    abstract public function newDto();

    public function __construct() {
        $this->init();
    }

    public function init() {
        $this->builder = $this->getBuilder();
    }
   
    /**
     * @Route("/{id}", methods={"GET"})
     */
    abstract public function getByIdAction(Request $request, $id);
    /**
     * @Route("", methods={"GET"}))
     */
    abstract public function getAllAction(Request $request, $response);

    /**
     * @Route("", methods={"POST"}))
     */
    abstract public function createAction(Request $request);

    /**
     * @Route("/{id}", methods={"DELETE"}))
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
