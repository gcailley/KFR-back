<?php

namespace RoutanglangquanBundle\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Controller\Api\AbstractApiController;
use RoutanglangquanBundle\Form\Builder\Tresorie\RtlqTresorieBuilder;
use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieDTO;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/api/tresorie/tresories")
 */
class TresorieController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Tresorie\RtlqTresorie';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Tresorie\RtlqTresorieType";
	}

	protected function getBuilder() {
		return new RtlqTresorieBuilder();
	}
	
	protected  function newDto() {
		return new RtlqTresorieDTO();
	}

}