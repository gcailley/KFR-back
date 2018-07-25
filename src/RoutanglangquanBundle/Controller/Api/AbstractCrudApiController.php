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
use RoutanglangquanBundle\Controller\Api\AbstractApiController;
 
abstract class AbstractCrudApiController extends AbstractApiController
{

    
    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    public function getByIdAction(Request $request, $id)
    {
        $tresorie = $this->getDoctrine()->getRepository($this->getName())->find($id);

        if (!is_object($tresorie)) {
            throw $this->createNotFoundException();
        }
        $dto_tresorie = $this->builder->modeleToDto($tresorie, $this);

        return  $this->newResponse(json_encode($dto_tresorie), Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request, $response=true)
    {
        $tresories = $this->getDoctrine()->getRepository($this->getName())->findAll();

        $dto_tresories = $this->builder->modelesToDtos($tresories, $this);
        if ($response) {
            return $this->newResponse(json_encode($dto_tresories), Response::HTTP_ACCEPTED);
        } else {
            return $dto_tresories;
        }
    }

    /**
     * @Route("/{id}")
     * @Method("PUT")
     */
    public function updateAction($id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $entityDB = $this->getDoctrine()->getRepository($this->getName())->find($id);

        $em = $this->getDoctrine()->getManager();
        $entityDto = $this->newDto();
        $form = $this->createForm($this->getNameType(), $entityDto);
        $form->submit($data);

        //validation de l'object DTO
        $errors = $this->getValidator()->doPutValidateDto($entityDto, $em);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        // convertion to Modele
        $entity = $this->builder->dtoToModele($em, $entityDto, $entityDB, $this);

        $em->merge($entity);
        $em->flush();

        $dto = $this->builder->modeleToDto($entity, $this);
        return $this->newResponse(json_encode($dto), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("")
     * @Method("POST")
     */
    public function createAction(Request $request, $response = true)
    {


        $data = json_decode($request->getContent(), true);

        $entityDto = $this->newDto();
        $form = $this->createForm($this->getNameType(), $entityDto);
        $form->submit($data);

        // recuperation entityManager
        $em = $this->getDoctrine()->getManager();

        //validation de l'object DTO
        $validator = $this->getValidator();
        $errors = $validator->doPostValidateDto($entityDto);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        //convertir en objet metier
        $modele = $this->getNewModeleInstance();
        $entityMetier = $this->builder->dtoToModele($em, $entityDto, $modele, $this);

        //action à faire dans le controller
        $this->innerCreateAction($em, $entityMetier);

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

        if ($response) {
            $dto = $this->builder->modeleToDto($entityMetier, $this);
            return $this->newResponse(json_encode($dto), Response::HTTP_CREATED);
        } else {
            return $entityMetier;
        }
    }

    protected function innerCreateAction($em, $entityMetier) {

    }

    protected function preConditionCreationAction($em, $entityMetier)
    {
        return null;
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteByIdAction($id)
    {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);

        if (!is_object($entity)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $this->internalDeleteByIdAction($em, $entity);
        $em->remove($entity);
        $em->flush();

        return $this->newResponse(null, Response::HTTP_NO_CONTENT);
    }

    protected function internalDeleteByIdAction($em, $entity)
    {
    }


    protected function getNewModeleInstance() {
        
        $entityname = str_replace(":", "\\Entity\\", $this->getName()) ;
        return new $entityname;
    }

    protected function returnNewResponse($entities, $statusCode) {
        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            $dto_entities = $this->builder->modelesToDtos($entities, $this);
        }
        return new Response(json_encode($dto_entities), $statusCode);
    }
}
