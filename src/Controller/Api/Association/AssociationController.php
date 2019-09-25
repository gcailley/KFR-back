<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Association\RtlqAssociation;
use App\Form\Builder\Association\RtlqAssociationBuilder;
use App\Form\Dto\Association\RtlqAssociationDTO;
use App\Form\Type\Association\RtlqAssociationType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/associations")
 */
class AssociationController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqAssociationType::class;}
    function newDtoClass(): string {return RtlqAssociationDTO::class;}
    function newBuilderClass(): string {return RtlqAssociationBuilder::class;}
    function newModeleClass(): string {return RtlqAssociation::class;}

}
