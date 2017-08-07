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

abstract class AbstractCrudApiController extends Controller {

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
    public function getByIdAction($id) {
        $tresorie = $this->getDoctrine()->getRepository($this->getName())->find($id);

        if (!is_object($tresorie)) {
            throw $this->createNotFoundException();
        }
        $dto_tresorie = $this->builder->modeleToDto($tresorie);
        
        return  $this->newResponse(json_encode($dto_tresorie), Response::HTTP_ACCEPTED);        
    }

    /**
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request) {
        $tresories = $this->getDoctrine()->getRepository($this->getName())->findAll();

        $dto_tresories = $this->builder->modelesToDtos($tresories);
        return $this->newResponse(json_encode($dto_tresories), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}")
     * @Method("PUT")
     */
    public function updateAction($id, Request $request) {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $this->getByIdAction($id);

        $entityDto = $this->newDto();
        $form = $this->createForm($this->getNameType(), $entityDto);
        $form->submit($data);

        $em = $this->getDoctrine()->getManager();
        $entity = $this->builder->dtoToModele($em, $entityDto);
        $entity->setId($id);

        //dovalidation
        $errors = $this->getValidator()->doPutValidate($entityDto, $entity);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        $em->merge($entity);
        $em->flush();

        $dto = $this->builder->modeleToDto($entity);
        return $this->newResponse(json_encode($dto), Response::HTTP_ACCEPTED);
    }

    protected function preConditionCreationAction($em, $entityMetier) {
        return null;
    }

    /**
     * @Route("")
     * @Method("POST")
     */
    public function createAction(Request $request) {
        $data = json_decode($request->getContent(), true);

        $entityDto = $this->newDto();
        $form = $this->createForm($this->getNameType(), $entityDto);
        $form->submit($data);

        $em = $this->getDoctrine()->getManager();
        $entityMetier = $this->builder->dtoToModele($em, $entityDto);

        //dovalidation
        $errors = $this->getValidator()->doPostValidate($entityDto, $entityMetier);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        try {
            $preConditionErrors = $this->preConditionCreationAction($em, $entityMetier);
            if ($preConditionErrors != null && sizeof($preConditionErrors) != 0) {
                throw $this->createInvalideBean($preConditionErrors);
            }
        } catch (Exception $exc) {
            $errors[] = "PréCondition non effectuées : " . $exc;
            throw $this->createInvalideBean($errors);
        }

        $em->persist($entityMetier);
        $em->flush();

        $dto = $this->builder->modeleToDto($entityMetier);
        return $this->newResponse(json_encode($dto), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteByIdAction($id) {
        $tresorie = $this->getDoctrine()->getRepository($this->getName())->find($id);

        if (!is_object($tresorie)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $this->internalDeleteByIdAction($em, $tresorie);
        $em->remove($tresorie);
        $em->flush();

        return $this->newResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected  function internalDeleteByIdAction($em , $entity) {
    }
    
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
