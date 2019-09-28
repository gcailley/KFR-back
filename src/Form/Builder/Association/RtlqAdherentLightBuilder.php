<?php

namespace App\Form\Builder\Association;

use App\Form\Builder\AbstractRtlqBuilder;


class RtlqAdherentLightBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setNom($postModele->getNom());
        $modele->setPrenom($postModele->getPrenom());

        return $modele;
    }

    public function modeleToDto($modele, $dtoClass)
    {
        $dto = new $dtoClass;

        $dto->setId($modele->getId());
        $dto->setNom($modele->getNom());
        $dto->setPrenom($modele->getPrenom());

        return $dto;
    }
}
