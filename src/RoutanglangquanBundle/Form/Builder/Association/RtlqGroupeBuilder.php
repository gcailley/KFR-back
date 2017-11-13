<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqGroupeDTO;
use RoutanglangquanBundle\Entity\Association\RtlqGroupe;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqGroupeBuilder extends AbstractRtlqBuilder
{
    private $rtlqAdherentBuilder;

    public function __construct()
    {
        $this->rtlqAdherentBuilder = new RtlqAdherentBuilder();
    }
    

    public function dtoToModele($em, $postModele, $controller)
    {
        $modele = new RtlqGroupe ();
        $modele->setId ( $postModele->getId () );
        $modele->setNom( $postModele->getNom () );
        foreach ($postModele->getAdherents() as $adherentDto) {
            $modele->addAdherent($em->getReference ( "RoutanglangquanBundle\Entity\Association\RtlqAdherent", $adherentDto['id'] )) ;
        }
        return $modele;
    }
    
    
    public function modeleToDto($modele)
    {
        $dto = new RtlqGroupeDTO ();
        
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom() );

        foreach ($modele->getAdherents() as $adherent) {
			$adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent);
            $dto->addAdherent( $adherentDto );
        }
		
		return $dto;
    }
}
