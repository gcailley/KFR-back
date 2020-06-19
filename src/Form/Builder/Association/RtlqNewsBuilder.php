<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqNewsDTO;
use App\Entity\Association\RtlqNews;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqNewsBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setTitle( $postModele->getTitle () );
        $modele->setDescription( $postModele->getDescription () );
        $modele->setLink( $postModele->getLink () );
        $modele->setActif( $postModele->isActif () );
        $modele->setDateCreation( $postModele->getDateCreation ()->setTime(12,0,0));
                
        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
		$dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setTitle ( $modele->getTitle() );
        $dto->setDescription ( $modele->getDescription() );
        $dto->setLink ( $modele->getLink() );
        $dto->setDateCreation ( $this->dateToString($modele->getDateCreation()));
        $dto->setActif ( $modele->isActif() );
		
		return $dto;
    }
}
