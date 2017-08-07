<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqGroupeBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqGroupeDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/api/association/groupes")
 */
class GroupeController extends AbstractCrudApiController {

    protected function getName() {
        return 'RoutanglangquanBundle:Association\RtlqGroupe';
    }

    protected function getNameType() {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqGroupeType";
    }

    protected function getBuilder() {
        return new RtlqGroupeBuilder();
    }

    protected function newDto() {
        return new RtlqGroupeDTO();
    }

    
    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllAdherents();
    }

}
