<?php

namespace RoutanglangquanBundle\Form\Builder\Tresorie;

use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieDTO;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqTresorieBuilder extends AbstractRtlqBuilder {
	public function dtoToModele($em, $postModele) {
		$modele = new RtlqTresorie ();
		
		$modele->setId ( $postModele->getId () );
		$modele->setDescription ( $postModele->getDescription () );
		$modele->setResponsable ( $postModele->getResponsable () );
		$modele->setAdherent ( $postModele->getAdherent () );
		$modele->setDateCreation ( $postModele->getDateCreation () );
		$modele->setMontant ( $postModele->getMontant () );
		$modele->setCheque ( $postModele->getCheque () );
		$modele->setNumeroCheque ( $postModele->getNumeroCheque () );
		
		$modele->setEtat ( $em->getReference ( "RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat", $postModele->getEtatId () ) );
		$modele->setCategorie ( $em->getReference ( "RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie", $postModele->getCategorieId () ) );
		$modele->setSaison ( $em->getReference ( "RoutanglangquanBundle\Entity\Saison\RtlqSaison", $postModele->getSaisonId () ) );
		
		return $modele;
	}
	
	
	public function modeleToDto($modele) {
		$dto = new RtlqTresorieDTO ();
		
		$dto->setId ( $modele->getId () );
		$dto->setDescription ( $modele->getDescription () );
		$dto->setResponsable ( $modele->getResponsable () );
		$dto->setAdherent ( $modele->getAdherent () );
		$dto->setDateCreation ( $this->dateToString ( $modele->getDateCreation () ) );
		$dto->setMontant ( $modele->getMontant () );
		$dto->setCheque ( $modele->getCheque () );
		$dto->setNumeroCheque ( $modele->getNumeroCheque () );
		
		$dto->setEtatId ( $modele->getEtatId () );
		$dto->setCategorieId ( $modele->getCategorieId () );
		$dto->setSaisonId ( $modele->getSaisonId () );
		
		return $dto;
	}
}
