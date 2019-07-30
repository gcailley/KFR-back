<?php

namespace App\Form\Builder\Association;

use App\Entity\Assciation\RtlqBenevolat;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Association\RtlqBenevolatDTO;

class RtlqBenevolatBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele, $controller)
    {
        $modele->setDescription ( $dto->getDescription () );
        $modele->setHeure ( $dto->getHeure() );
        $modele->setMinute($dto->getMinute() );
        $modele->setDateCreation($dto->getDateCreation()->setTime(12,0,0) );

        $modele->setSaison ( $em->getReference ( "App\Entity\Saison\RtlqSaison", $dto->getSaisonId () ) );
        $modele->setAdherent ( $em->getReference ( "App\Entity\Association\RtlqAdherent", $dto->getAdherentId () ) );
        $modele->setCategorie ( $em->getReference ( "App\Entity\Tresorie\RtlqTresorieCategorie", $dto->getCategorieId () ) );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setDescription ( $modele->getDescription () );
        $dto->setHeure ( $modele->getHeure() );
        $dto->setMinute ( $modele->getMinute() );
        $dto->setDateCreation( $this->dateToString($modele->getDateCreation() ));

        $dto->setSaisonName ( $modele->getSaisonNom () );
        $dto->setSaisonId ( $modele->getSaisonId () );
        $dto->setAdherentName ( $modele->getAdherentPrenomNom () );
        $dto->setAdherentId ( $modele->getAdherentId () );
        $dto->setCategorieName ( $modele->getCategorieNom () );
        $dto->setCategorieId ( $modele->getCategorieId () );


        return $dto;
    }
}
