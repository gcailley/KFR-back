<?php

namespace App\Controller\Api;

use GuzzleHttp\json_encode;
use App\Form\Validator\RtlqValidator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Controller\Api\AbstractApiController;
 
abstract class AbstractCrudApiController extends AbstractApiController
{

    
    /**
     * @Route("/{id}", methods={"GET"})
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
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC']
     */
    public function defaultSort() {
        return [];
    }


    public function convertModele2DtoResponse($response, $entityMetier, $status) {
        if ($response) {
            $dto = $this->builder->modeleToDto($entityMetier, $this);
            return $this->newResponse(json_encode($dto), $status);
        } else {
            return $entityMetier;
        }
    }

    public function convertDto2Response($response, $dtoEntities, $status) {
        if ($response) {
            return $this->newResponse(json_encode($dtoEntities), $status);
        } else {
            return $dtoEntities;
        }
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response=true)
    {
        $tresories = $this->getDoctrine()->getRepository($this->getName())->findBy([], $this->defaultSort());
        
        $dto_tresories = $this->builder->modelesToDtos($tresories, $this);
        return $this->convertDto2Response($dto_tresories, $response, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function updateAction($id, Request $request, $response =true)
    {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $entityDB = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entityDB)) {
            throw $this->createNotFoundException();
        }

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
        $entityMetier = $this->builder->dtoToModele($em, $entityDto, $entityDB, $this);

        //action à faire dans le controller
        $this->updateBeforeSaved($em, $entityMetier);

        $em->merge($entityMetier);
        $em->flush();

        return $this->convertModele2DtoResponse($response, $entityMetier, Response::HTTP_ACCEPTED);
    }

    protected function updateBeforeSaved($em, $entityMetier) {
    }


    /**
     * @Route("", methods={"POST"})
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

        return $this->convertModele2DtoResponse($response, $entityMetier, Response::HTTP_CREATED);
    }


    protected function innerCreateAction($em, $entityMetier) {
    }

    protected function preConditionCreationAction($em, $entityMetier)
    {
        return null;
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
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
