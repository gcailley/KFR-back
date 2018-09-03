<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqAssociationBuilder;
use App\Form\Dto\Association\RtlqAssociationDTO;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/associations")
 */
class AssociationController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Association\RtlqAssociation';
    }

    function getNameType()
    {
        return "App\Form\Type\Association\RtlqAssociationType";
    }

    protected function getBuilder()
    {
        return new RtlqAssociationBuilder();
    }
    
    function newDto()
    {
        return new RtlqAssociationDTO();
    }
}
