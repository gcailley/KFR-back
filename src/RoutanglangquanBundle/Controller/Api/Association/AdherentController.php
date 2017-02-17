<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api/association/adherent")
 */
class AdherentController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Association\RtlqAdherent';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Association\RtlqAdherentType";
	}

	protected function getBuilder() {
		return new RtlqAdherentBuilder();
	}
	
	protected  function newDto() {
		return new RtlqAdherentDTO();
	}

}