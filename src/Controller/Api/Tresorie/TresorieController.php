<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\json_encode;
use App\Form\Builder\Tresorie\RtlqTresorieBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Controller\Api\AbstractCrudApiController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/tresorie/tresories")
 */
class TresorieController extends AbstractCrudApiController
{
    public function getName()
    {
        return 'App:Tresorie\RtlqTresorie';
    }

    public function getNameType()
    {
        return "App\Form\Type\Tresorie\RtlqTresorieType";
    }

    protected function getBuilder()
    {
        return new RtlqTresorieBuilder();
    }

    public function newDto()
    {
        return new RtlqTresorieDTO();
    }

    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateCreation' => 'DESC'];
    }

    /**
     * @Route("/by-user-{id}", methods={"GET"})
     */
    public function getTresoriesByUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tresorieRepo = $em->getRepository("App\Entity\Tresorie\RtlqTresorie");
        $entity = $tresorieRepo->findAllTresorieFilterByAdherent($id);

        if (null == $entity) {
            throw new NotFoundHttpException("No tresorie Found for $id");
        }

        $dtos = $this->builder->modelesToDtos($entity);

        return new Response(json_encode($dtos), 201);
    }
}
