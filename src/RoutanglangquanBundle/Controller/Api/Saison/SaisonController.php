<?php

namespace RoutanglangquanBundle\Controller\Api\Saison;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Saison\RtlqSaisonBuilder;
use RoutanglangquanBundle\Form\Dto\Saison\RtlqSaisonDTO;
use RoutanglangquanBundle\Form\Validator\Saison\RtlqSaisonValidator;

/**
 * @Route("/api/saisons")
 */
class SaisonController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Saison\RtlqSaison';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Saison\RtlqSaisonType";
	}

	protected function getBuilder() {
		return new RtlqSaisonBuilder();
	}
	
	protected  function newDto() {
		return new RtlqSaisonDTO();
	}

	
	/**
	 * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
	 *
	 */
	public function getValidator() {
		return new RtlqSaisonValidator();
	}
}