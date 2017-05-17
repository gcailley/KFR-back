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
use RoutanglangquanBundle\Repository\Tresorie\TresorieRepository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        
     /**
     * @Route("/by-user-{id}")
     * @Method("GET")
     */
    public function getTresoriesByUser($id) {
        
        $em = $this->getDoctrine()->getManager();
        $tresorieRepo = $em->getRepository("RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie");
        $entity = $tresorieRepo->findAllTresorieFilterByAdherent($id);
        
        if ($entity == null) {
            throw new NotFoundHttpException("No tresorie Found for $id");
        }

        dump($entity);
        
        $dtos = $this->builder->modelesToDtos($entity);        
        return new Response(json_encode($dtos), 201);
    }
}