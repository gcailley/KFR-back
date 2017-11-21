<?php

namespace RoutanglangquanBundle\Form\Builder;

use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieDTO;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

abstract class AbstractRtlqEnumBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele->setValue($postModele->getValue() );
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        $dto->setId ( $modele->getId ());
        $dto->setValue ( $modele->getValue() );
        
        return $dto;
    }
}
