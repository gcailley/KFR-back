<?php

namespace RoutanglangquanBundle\Controller\Api\Kungfu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Form\Builder\Kungfu\RtlqKungfuStyleBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqKungfuStyleDTO;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/api/kungfu/styles")
 */
class KungfuStyleController extends AbstractCrudApiController {
	
	protected function getName() {
		return 'RoutanglangquanBundle:Kungfu\RtlqKungfuStyle';
	}

	protected function getNameType() {
		return "RoutanglangquanBundle\Form\Type\Kungfu\RtlqKungfuStyleType";
	}

	protected function getBuilder() {
		return new RtlqKungfuStyleBuilder();
	}
	
	protected  function newDto() {
		return new RtlqKungfuStyleDTO();
	}

}