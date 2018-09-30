<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqAssociationDTO;
use App\Entity\Association\RtlqAssociation;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqAssociationBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele->setNom ( $postModele->getNom () );
        $modele->setEmail( $postModele->getEmail () );
        $modele->setSiegeSocial ( $postModele->getSiegeSocial () );
        $modele->setDateCreation ( $postModele->getDateCreation () );
        $modele->setActive($postModele->getActive() );
        $modele->setNumeroSiren($postModele->getNumeroSiren() );
        
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom() );
        $dto->setEmail($modele->getEmail ( ) );
        $dto->setSiegeSocial($modele->getSiegeSocial ( ) );
        $dto->setDateCreation( $this->dateToString ( $modele->getDateCreation () ) );
        $dto->setActive( $modele->getActive() );
        $dto->setNumeroSiren($modele->getNumeroSiren() );

        return $dto;
    }
}
