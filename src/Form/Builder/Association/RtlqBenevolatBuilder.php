<?php

namespace App\Form\Builder\Association;

use App\Entity\Assciation\RtlqBenevolat;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Association\RtlqBenevolatDTO;

class RtlqBenevolatBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setDescription ( $dto->getDescription () );
        $modele->setHeure ( $dto->getHeure() );
        $modele->setMinute($dto->getMinute() );
        $modele->setDateCreation($dto->getDateCreation()->setTime(12,0,0) );

        $modele->setSaison ( $em->getReference ( RtlqSaison::class, $dto->getSaisonId () ) );
        $modele->setAdherent ( $em->getReference ( RtlqAdherent::class, $dto->getAdherentId () ) );
        $modele->setCategorie ( $em->getReference ( RtlqTresorieCategorie::class, $dto->getCategorieId () ) );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
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
