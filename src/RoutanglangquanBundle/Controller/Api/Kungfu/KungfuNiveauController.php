<?php

namespace RoutanglangquanBundle\Controller\Api\Kungfu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Form\Builder\Kungfu\RtlqKungfuNiveauBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqKungfuNiveauDTO;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/api/kungfu/niveaux")
 */
class KungfuNiveauController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Kungfu\RtlqKungfuNiveau';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Kungfu\RtlqKungfuNiveauType";
	}

	protected function getBuilder() {
		return new RtlqKungfuNiveauBuilder();
	}
	
	protected  function newDto() {
		return new RtlqKungfuNiveauDTO();
	}

}