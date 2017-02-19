<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function GuzzleHttp\json_encode;

/**
 * @Route("/api/association/adherents")
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

        /**
	 * @Route("/{id}/cotisations/{idCotisation}")
	 * @Method("POST")
	 */
	public function addCotisationToUser($id, $idCotisation) {
		$entity = $this->getDoctrine ()->getRepository ( $this->getName() )->find ($id);
                if (! is_object ( $entity )) {
			throw new NotFoundHttpException("Adherent $id not found");
		}
                $cotisation = $this->getDoctrine ()->getRepository ( "RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation" )->find ($idCotisation);
                if (! is_object ( $cotisation )) {
			throw new NotFoundHttpException("Cotisation $idCotisation not found");
		}                
                //add cotisation to adherent
                $entity->addCotisation($cotisation);

		$em = $this->getDoctrine()->getManager();                
                $em->merge($entity);
		$em->flush();

                $dto = $this->builder->modeleToDto($entity);
		return new Response(json_encode($dto), 201);
	}
            
        
        /**
	 * @Route("/{id}/groupes/{idGroupe}")
	 * @Method("POST")
	 */
	public function addGroupeToUser($id, $idGroupe) {
		$entity = $this->getDoctrine ()->getRepository ( $this->getName() )->find ($id);
                if (! is_object ( $entity )) {
			throw new NotFoundHttpException("Adherent $id not found");
		}
                $groupe = $this->getDoctrine ()->getRepository ( "RoutanglangquanBundle\Entity\Association\RtlqGroupe" )->find ($idGroupe);
                if (! is_object ( $groupe )) {
			throw new NotFoundHttpException("Groupe $idGroupe not found");
		}                
                //add groupe to adherent
                $entity->addGroupe($groupe);

		$em = $this->getDoctrine()->getManager();                
                $em->merge($entity);
		$em->flush();

                $dto = $this->builder->modeleToDto($entity);
		return new Response(json_encode($dto), 201);
	}
        
}