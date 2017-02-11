<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqGroupeDTO;
use RoutanglangquanBundle\Entity\Association\RtlqGroupe;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqGroupeBuilder extends AbstractRtlqBuilder {
	public function dtoToModele($em, $postModele) {
		$modele = new RtlqGroupe ();
		
		$modele->setId ( $postModele->getId () );
		$modele->setNom( $postModele->getNom () );

                foreach ($postModele->getAdherentsId() as $adherentId) {
                    $modele->addAdherent($em->getReference ( "RoutanglangquanBundle\Entity\Association\RtlqAdherent", $adherentId () )) ;
                }
                
		return $modele;
	}
	
	
	public function modeleToDto($modele) {
		$dto = new RtlqSaisonDTO ();
		
		$dto->setId ( $modele->getId () );
		$dto->setNom ( $modele->getNom() );

                foreach ($modele->getAdherents() as $adherent) {
                    $dto->addAdherent( $adherent->getId () );
                }
                
                return $dto;
	}
}
