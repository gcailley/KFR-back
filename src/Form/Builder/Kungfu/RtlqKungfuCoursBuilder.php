<?php

namespace App\Form\Builder\Kungfu;

use App\Form\Dto\Kungfu\RtlqKungfuCoursDTO;
use App\Entity\Kungfu\RtlqKungfuCours;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuCoursBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setDescription( $postModele->getDescription () );
        $modele->setThematiqueTao( $postModele->getThematiqueTao() );
        $modele->setThematiqueApplication( $postModele->getThematiqueApplication() );
        $modele->setThematiqueCombat( $postModele->getThematiqueCombat() );
        $modele->setDate( $postModele->getDate() );

        $modele->setSaison($em->getReference ( "App\Entity\Saison\RtlqSaison", $postModele->getSaisonId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        $dto->setId ( $modele->getId () );
        $dto->setDescription( $modele->getDescription () );
        $dto->setSaisonId( $modele->getSaisonId() );
        $dto->setSaisonName( $modele->getSaisonName() );

        $dto->setThematiqueTao( $modele->getThematiqueTao() );
        $dto->setThematiqueApplication( $modele->getThematiqueApplication() );
        $dto->setThematiqueCombat( $modele->getThematiqueCombat() );

        $dto->setDate($this->dateToString($modele->getDate()));


        return $dto;
    }
}
