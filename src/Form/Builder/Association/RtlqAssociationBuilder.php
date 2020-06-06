<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqAssociationDTO;
use App\Entity\Association\RtlqAssociation;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqAssociationBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setNom($dto->getNom());
        $modele->setEmail($dto->getEmail());
        $modele->setSiegeSocial($dto->getSiegeSocial());
        $modele->setDateCreation($dto->getDateCreation());
        $modele->setActive($dto->getActive());
        $modele->setNumeroSiren($dto->getNumeroSiren());
        $modele->setNumeroCompteBancaire($dto->getNumeroCompteBancaire());
        $modele->setUrlIntranet($dto->getUrlIntranet());
        $modele->setUrlExtranet($dto->getUrlExtranet());

        return $modele;
    }


    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setNom($modele->getNom());
        $dto->setEmail($modele->getEmail());
        $dto->setSiegeSocial($modele->getSiegeSocial());
        $dto->setDateCreation($this->dateToString($modele->getDateCreation()));
        $dto->setActive($modele->getActive());
        $dto->setNumeroSiren($modele->getNumeroSiren());
        $dto->setNumeroCompteBancaire($modele->getNumeroCompteBancaire());
        $dto->setUrlIntranet($modele->getUrlIntranet());
        $dto->setUrlExtranet($modele->getUrlExtranet());

        return $dto;
    }
}
