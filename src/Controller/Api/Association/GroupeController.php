<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Association\RtlqGroupe;
use App\Form\Builder\Association\RtlqGroupeBuilder;
use App\Form\Dto\Association\RtlqGroupeDTO;
use App\Form\Type\Association\RtlqGroupeType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;


/**
 * @Route("/association/groupes")
 */
class GroupeController extends AbstractCrudApiController {

    function newTypeClass(): string {return RtlqGroupeType::class;}
    function newDtoClass(): string {return RtlqGroupeDTO::class;}
    function newBuilderClass(): string {return RtlqGroupeBuilder::class;}
    function newModeleClass(): string {return RtlqGroupe::class;}


    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllAdherents();
    }

}
