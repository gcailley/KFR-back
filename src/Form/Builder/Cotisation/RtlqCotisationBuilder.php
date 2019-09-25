<?php

namespace App\Form\Builder\Cotisation;

use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Cotisation\RtlqCotisationDTO;

class RtlqCotisationBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setDescription ( $dto->getDescription () );
        $modele->setCotisation ( $dto->getCotisation() );
        $modele->setRepartitionCheque($dto->getRepartitionCheque() );
        $modele->setActive($dto->getActive() );
        $modele->setType($dto->getType() );
        $modele->setNbCheque($dto->getNbCheque() );

        $modele->setCategorie ( $em->getReference (RtlqTresorieCategoriee::class, $dto->getCategorieId () ) );
        $modele->setSaison ( $em->getReference ( RtlqSaison::class, $dto->getSaisonId () ) );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
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
