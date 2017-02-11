<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAssociationBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAssociationDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api/association")
 */
class AssociationController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Association\RtlqAssociation';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Association\RtlqAssociationType";
	}

	protected function getBuilder() {
		return new RtlqAssociationBuilder();
	}
	
	protected  function newDto() {
		return new RtlqAssociationDTO();
	}

}