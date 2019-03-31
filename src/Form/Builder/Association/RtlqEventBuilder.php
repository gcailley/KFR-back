<?php

namespace App\Form\Builder\Association;

use App\Entity\Assciation\RtlqEvent;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Association\RtlqEventDTO;

class RtlqEventBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele, $controller)
    {
        $modele->setDescription ( $dto->getDescription () );
        $modele->setCommentaire ( $dto->getCommentaire() );
        $modele->setAdresse($dto->getAdresse() );
        $modele->setDateCreation($dto->getDateCreation()->setTime(12,0,0) );

        $modele->setSaison ( $em->getReference ( "App\Entity\Saison\RtlqSaison", $dto->getSaisonId () ) );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setDescription ( $modele->getDescription () );
        $dto->setCommentaire ( $modele->getCommentaire () );
        $dto->setDateCreation( $this->dateToString($modele->getDateCreation() ));

        $dto->setSaisonName ( $modele->getSaisonNom () );
        $dto->setSaisonId ( $modele->getSaisonId () );
                
        return $dto;
    }
}
