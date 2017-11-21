<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqAssociationDTO;
use RoutanglangquanBundle\Entity\Association\RtlqAssociation;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqAssociationBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setNom ( $postModele->getNom () );
        $modele->setEmail( $postModele->getEmail () );
        $modele->setSiegeSocial ( $postModele->getSiegeSocial () );
        $modele->setDateCreation ( $postModele->getDateCreation () );
        $modele->setActive($postModele->getActive() );
        
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
        
        return $dto;
    }
}
