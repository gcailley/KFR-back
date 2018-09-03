<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqGroupeBuilder;
use App\Form\Dto\Association\RtlqGroupeDTO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;


/**
 * @Route("/association/groupes")
 */
class GroupeController extends AbstractCrudApiController {

    function getName() {
        return 'App:Association\RtlqGroupe';
    }

    function getNameType() {
        return "App\Form\Type\Association\RtlqGroupeType";
    }

    protected function getBuilder() {
        return new RtlqGroupeBuilder();
    }

    function newDto() {
        return new RtlqGroupeDTO();
    }
    
    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllAdherents();
    }

}
