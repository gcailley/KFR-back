<?php

namespace RoutanglangquanBundle\Form\Builder\Saison;

use RoutanglangquanBundle\Form\Dto\Saison\RtlqSaisonDTO;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqSaisonBuilder extends AbstractRtlqBuilder {
	public function dtoToModele($em, $postModele) {
		$modele = new RtlqSaison ();
		
		$modele->setId ( $postModele->getId () );
		$modele->setNom( $postModele->getNom () );
		$modele->setDateDebut ( $postModele->getDateDebut () );
		$modele->setDateFin ( $postModele->getDateFin () );
		$modele->setActive($postModele->getActive() );
		
		return $modele;
	}
	
	
	public function modeleToDto($modele) {
		$dto = new RtlqSaisonDTO ();
		
		$dto->setId ( $modele->getId () );
		$dto->setNom ( $modele->getNom() );
		$dto->setDateDebut( $this->dateToString ( $modele->getDateDebut () ) );
		$dto->setDateFin( $this->dateToString ( $modele->getDateFin () ) );
		$dto->setActive( $modele->getActive() );
		
		return $dto;
	}
}
