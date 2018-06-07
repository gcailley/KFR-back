<?php

namespace RoutanglangquanBundle\Form\Builder\Cotisation;

use RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Dto\Cotisation\RtlqCotisationDTO;

class RtlqCotisationBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele, $controller)
    {
        $modele->setDescription ( $dto->getDescription () );
        $modele->setCotisation ( $dto->getCotisation() );
        $modele->setRepartitionCheque($dto->getRepartitionCheque() );
        $modele->setActive($dto->getActive() );
        $modele->setType($dto->getType() );
        $modele->setNbCheque($dto->getNbCheque() );

        $modele->setCategorie ( $em->getReference ( "RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie", $dto->getCategorieId () ) );
        $modele->setSaison ( $em->getReference ( "RoutanglangquanBundle\Entity\Saison\RtlqSaison", $dto->getSaisonId () ) );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setDescription ( $modele->getDescription () );
        $dto->setCotisation ( $modele->getCotisation () );
        $dto->setRepartitionCheque($modele->getRepartitionCheque() );
        $dto->setActive($modele->getActive() );
        $dto->setType($modele->getType() );
        $dto->setNbCheque($modele->getNbCheque() );
        
        $dto->setCategorieName ( $modele->getCategorieNom() );
        $dto->setCategorieId ( $modele->getCategorieId () );
        $dto->setSaisonName ( $modele->getSaisonNom () );
        $dto->setSaisonId ( $modele->getSaisonId () );
                
        return $dto;
    }
}
