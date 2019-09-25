<?php

namespace App\Form\Builder\Materiel;

use App\Form\Dto\Materiel\RtlqMaterielDTO;
use App\Entity\Materiel\RtlqMateriel;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqMaterielBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setNom ( $postModele->getNom () );
        $modele->setPrixAchat ( $postModele->getPrixAchat () );
        $modele->setPrixVente( $postModele->getPrixVente () );
        $modele->setDateAchat( $postModele->getDateAchat() );
        $modele->setStock( $postModele->getStock() );
        $modele->setAssociation( $postModele->getAssociation() );

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom () );
        $dto->setPrixAchat ( $modele->getPrixAchat () );
        $dto->setPrixVente ( $modele->getPrixVente () );
        $dto->setDateAchat( $this->dateToString($modele->getDateAchat ()) );
        $dto->setStock( $modele->getStock() );
        $dto->setAssociation( $modele->getAssociation() );

        return $dto;
    }
}
