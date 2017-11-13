<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqNewsDTO;
use RoutanglangquanBundle\Entity\Association\RtlqNews;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqNewsBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $postModele, $controller)
    {
        $modele = new RtlqNews ();

        $modele->setId ( $postModele->getId () );
        $modele->setTitle( $postModele->getTitle () );
        $modele->setDescription( $postModele->getDescription () );
        $modele->setLink( $postModele->getLink () );
        $modele->setActif( $postModele->isActif () );
        $modele->setDateCreation( $postModele->getDateCreation () );
                
        return $modele;
    }
    
    
    public function modeleToDto($modele)
    {
        $dto = new RtlqNewsDTO ();
        
        $dto->setId ( $modele->getId () );
        $dto->setTitle ( $modele->getTitle() );
        $dto->setDescription ( $modele->getDescription() );
        $dto->setLink ( $modele->getLink() );
        $dto->setDateCreation ( $this->dateToString($modele->getDateCreation()));
        $dto->setActif ( $modele->isActif() );
		
		return $dto;
    }
}
