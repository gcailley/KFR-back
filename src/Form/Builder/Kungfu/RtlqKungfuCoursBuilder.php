<?php

namespace App\Form\Builder\Kungfu;

use App\Form\Dto\Kungfu\RtlqKungfuCoursDTO;
use App\Entity\Kungfu\RtlqKungfuCours;
use App\Entity\Saison\RtlqSaison;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuCoursBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setDescription( $postModele->getDescription () );
        $modele->setThematiqueTao( $postModele->getThematiqueTao() );
        $modele->setThematiqueApplication( $postModele->getThematiqueApplication() );
        $modele->setThematiqueCombat( $postModele->getThematiqueCombat() );
        $modele->setDate( $postModele->getDateCreation() );
        $modele->setNbCoursEssais( $postModele->getNbCoursEssais() );
        

        $modele->setSaison($em->getReference ( RtlqSaison::class, $postModele->getSaisonId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setDescription( $modele->getDescription () );
        $dto->setSaisonId( $modele->getSaisonId() );
        $dto->setSaisonName( $modele->getSaisonName() );

        $dto->setThematiqueTao( $modele->getThematiqueTao() );
        $dto->setThematiqueApplication( $modele->getThematiqueApplication() );
        $dto->setThematiqueCombat( $modele->getThematiqueCombat() );

        $dto->setDateCreation($this->dateToString($modele->getDate()));
        $dto->setNbCoursEssais($modele->getNbCoursEssais());

        

        return $dto;
    }
}
