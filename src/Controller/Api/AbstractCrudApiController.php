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
        $tresorie = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);

        if (!is_object($tresorie)) {
            throw $this->createNotFoundException();
        }
        $dto_tresorie = $this->getBuilder()->modeleToDto($tresorie, $this->newDtoClass());

        return  $this->newResponse($dto_tresorie, Response::HTTP_ACCEPTED);
    }

    /** 
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC']
     */
    public function defaultSort() {
        return [];
    }


    public function convertModele2DtoResponse($entityMetier, $response, $status) {
        if ($response) {
            $dto = $this->getBuilder()->modeleToDto($entityMetier,  $this->newDtoClass());
            return $this->newResponse($dto, $status);
        } else {
            return $entityMetier;
        }
    }

    public function convertDto2Response($dtoEntities, $response, $status) {
        if ($response) {
            return $this->newResponse($dtoEntities, $status);
        } else {
            return $dtoEntities;
        }
    }

    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response=true)
    {
        $tresories = $this->getDoctrine()->getRepository($this->newModeleClass())->findBy([], $this->defaultSort());
        
        $dto_tresories = $this->getBuilder()->modelesToDtos($tresories,  $this->newDtoClass());
        return $this->convertDto2Response($dto_tresories, $response, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function updateAction($id, Request $request, $response =true)
    {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $entityDB = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entityDB)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $entityDto = $this->newDto();
        $form = $this->createForm($this->newTypeClass(), $entityDto);
        $form->submit($data);

        //validation de l'object DTO
        $errors = $this->getValidator()->doPutValidateDto($entityDto, $em);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        // convertion to Modele
        $entityMetier = $this->getBuilder()->dtoToModele($em, $entityDto, $entityDB);

        //action à faire dans le controller
        $this->updateBeforeSaved($em, $entityMetier);

        $em->merge($entityMetier);
        $em->flush();

        return $this->convertModele2DtoResponse($entityMetier, $response, Response::HTTP_ACCEPTED);
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
        $form = $this->createForm( $this->newTypeClass(), $entityDto);
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
        $entityMetier = $this->getBuilder()->dtoToModele($em, $entityDto, $modele);

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

        return $this->convertModele2DtoResponse($entityMetier, $response, Response::HTTP_CREATED);
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
        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);

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
        $modeleClass = $this->newModeleClass();
        return new $modeleClass;
    }

    protected function returnNewResponse($entities, $statusCode = Response::HTTP_ACCEPTED, $convert = true ) {
        if ($entities === null || empty($entities)) {
            $dto_entities = [];
        } else {
            if ($convert) {
                $dto_entities = $this->getBuilder()->modelesToDtos($entities, $this->newDtoClass());
            } else {
                $dto_entities = $entities;
            }
        }
        return new Response(json_encode($dto_entities), $statusCode);
    }

    protected function returnNotFoundResponse() {
        return $this->returnNewResponse(null, Response::HTTP_NOT_FOUND);
    }

    protected function returnUnAuthorizedResponse() {
        return $this->returnNewResponse(null, Response::HTTP_UNAUTHORIZED);
    }
}
