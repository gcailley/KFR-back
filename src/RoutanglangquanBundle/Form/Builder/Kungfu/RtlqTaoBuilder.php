<?php

namespace RoutanglangquanBundle\Form\Builder\Kungfu;

use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqTaoDTO;
use RoutanglangquanBundle\Entity\Kungfu\RtlqTao;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqTaoBuilder extends AbstractRtlqBuilder {
	public function dtoToModele($em, $postModele, $controller) {
		$modele = new RtlqTao ();
		
		$modele->setId ( $postModele->getId () );
		$modele->setNom ( $postModele->getNom () );
		$modele->setNomChinois ( $postModele->getNomChinois () );
		$modele->setDescription( $postModele->getDescription () );
		$modele->setArme( $postModele->getArme() );
		$modele->setArmeUrl( $postModele->getArmeUrl() );
		$modele->setVideoUrl( $postModele->getVideoUrl() );
		$modele->setActif( $postModele->getActif() );

		$modele->setStyle($em->getReference ( "RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuStyle", $postModele->getStyleId ())) ;
		$modele->setNiveau($em->getReference ( "RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuNiveau", $postModele->getNiveauId ())) ;

		return $modele;
	}
	
	
	public function modeleToDto($modele) {
		$dto = new RtlqTaoDTO ();
		
		$dto->setId ( $modele->getId () );
		$dto->setNom ( $modele->getNom () );
		$dto->setNomChinois ( $modele->getNomChinois () );
		$dto->setDescription( $modele->getDescription () );
		$dto->setArme( $modele->getArme() );
		$dto->setArmeUrl( $modele->getArmeUrl() );
		$dto->setVideoUrl( $modele->getVideoUrl() );
		$dto->setStyleId( $modele->getStyleId() );
		$dto->setStyleName( $modele->getStyleName() );
		$dto->setNiveauId( $modele->getNiveauId() );
		$dto->setNiveauName( $modele->getNiveauName() );
		$dto->setActif( $modele->getActif() );

		return $dto;
	}
}
