<?php

namespace RoutanglangquanBundle\Form\Builder\Materiel;

use RoutanglangquanBundle\Form\Dto\Materiel\RtlqMaterielDTO;
use RoutanglangquanBundle\Entity\Materiel\RtlqMateriel;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqMaterielBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setNom ( $postModele->getNom () );
        $modele->setPrixAchat ( $postModele->getPrixAchat () );
        $modele->setPrixVente( $postModele->getPrixVente () );
        $modele->setDateAchat( $postModele->getDateAchat() );
        $modele->setStock( $postModele->getStock() );
        $modele->setAssociation( $postModele->getAssociation() );

        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom () );
        $dto->setPrixAchat ( $modele->getPrixAchat () );
        $dto->setPrixVente ( $modele->getPrixVente () );
        $dto->setDateAchat( $modele->getDateAchat () );
        $dto->setStock( $modele->getStock() );
        $dto->setAssociation( $modele->getAssociation() );

        return $dto;
    }
}
