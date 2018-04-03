<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqGroupeBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqGroupeDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/association/groupes")
 */
class GroupeController extends AbstractCrudApiController {

    function getName() {
        return 'RoutanglangquanBundle:Association\RtlqGroupe';
    }

    function getNameType() {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqGroupeType";
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
