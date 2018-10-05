<?php

namespace App\Form\Builder;

use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Tresorie\RtlqTresorieEtat;
use App\Entity\Saison\RtlqSaison;
use App\Form\Builder\AbstractRtlqBuilder;

abstract class AbstractRtlqEnumBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele->setValue($postModele->getNom() );
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        $dto->setId ( $modele->getId ());
        $dto->setNom ( $modele->getValue() );
        
        return $dto;
    }
}
