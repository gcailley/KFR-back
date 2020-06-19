<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\json_encode;
use App\Form\Builder\Tresorie\RtlqTresorieBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Controller\Api\AbstractCrudApiController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Tresorie\RtlqTresorie;
use App\Form\Type\Tresorie\RtlqTresorieType;

/**
 * @Route("/tresorie/tresories")
 */
class TresorieController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqTresorieType::class;}
    function newDtoClass(): string {return RtlqTresorieDTO::class;}
    function newBuilderClass(): string {return RtlqTresorieBuilder::class;}
    function newModeleClass(): string {return RtlqTresorie::class;}

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
        $tresorieRepo = $em->getRepository(RtlqTresorie::class);
        $entity = $tresorieRepo->findAllTresorieFilterByAdherent($id);

        if (null == $entity) {
            throw new NotFoundHttpException("No tresorie Found for $id");
        }

        $dtos = $this->getBuilder()->modelesToDtos($entity, RtlqTresorieDTO::class, $this->getDoctrine());

        return new Response(json_encode($dtos), 201);
    }
}
