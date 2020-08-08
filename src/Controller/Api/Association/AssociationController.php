<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Association\RtlqAssociation;
use App\Form\Builder\Association\RtlqAssociationBuilder;
use App\Form\Dto\Association\RtlqAssociationDTO;
use App\Form\Type\Association\RtlqAssociationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/associations")
 */
class AssociationController extends AbstractCrudApiController
{
    function newTypeClass(): string
    {
        return RtlqAssociationType::class;
    }
    function newDtoClass(): string
    {
        return RtlqAssociationDTO::class;
    }
    function newBuilderClass(): string
    {
        return RtlqAssociationBuilder::class;
    }
    function newModeleClass(): string
    {
        return RtlqAssociation::class;
    }

    /**
     * @Route("/active", methods={"GET"})
     */
    public function getActiveAction(Request $request)
    {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
            ->createQueryBuilder('a')
            ->where('a.active = :active')
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }
}
