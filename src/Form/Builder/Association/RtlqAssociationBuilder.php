<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqAssociationDTO;
use App\Entity\Association\RtlqAssociation;
use App\Entity\Association\RtlqBureau;
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


    public function modeleToDto($modele, $dtoClass, $doctrine)
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

        // recuperation current "bureau" and initialize president, tresorerier, secretaire
        $bureau = $doctrine->getRepository(RtlqBureau::class)->getBureauActif();
        if ($bureau) {
            $dto->setPresidentId($bureau->getPresident()->getId());
            $dto->setPresidentNomPrenom($bureau->getPresident()->getPrenomNom());
            $dto->setTresorierId($bureau->getTresorier()->getId());
            $dto->setTresorierNomPrenom($bureau->getTresorier()->getPrenomNom());
            $dto->setSecretaireId($bureau->getSecretaire()->getId());
            $dto->setSecretaireNomPrenom($bureau->getSecretaire()->getPrenomNom());
        }

        return $dto;
    }
}
