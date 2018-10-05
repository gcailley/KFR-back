<?php

namespace App\Form\Builder\Tresorie;

use App\Form\Builder\AbstractRtlqEnumBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieEtatDTO;
use App\Entity\Tresorie\RtlqTresorieEtat;

class RtlqTresorieEtatBuilder extends AbstractRtlqEnumBuilder {
    
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele = parent::dtoToModele($em, $postModele, $modele, $controller);
        if ( $postModele->getNextEtatId () != null) {
            $modele->setNextEtat ( $em->getReference(RtlqTresorieEtat::class, $postModele->getNextEtatId ()));
        }
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = parent::modeleToDto($modele, $controller);
        $dto->setNextEtatId ( $modele->getNextEtatId () );
        $dto->setNextEtatName ( $modele->getNextEtatName () );

        return $dto;
    }

}
