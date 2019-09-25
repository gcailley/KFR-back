<?php

namespace App\Form\Builder\Saison;

use App\Entity\Saison\RtlqCategorieVotee;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Saison\RtlqSaison;

use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Saison\RtlqCategorieVoteeDTO;

class RtlqCategorieVoteeBuilder extends AbstractRtlqBuilder
{
    
    public function __construct()
    {
    }

    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setMontant($dto->getMontant());
        if ($dto->getSaisonId() != null) {
            $modele->setSaison($em->getReference(RtlqSaison::class, $dto->getSaisonId() ));
        }
        if ($dto->getCategorieId() != null) {
            $modele->setCategorie($em->getReference(RtlqTresorieCategorie::class, $dto->getCategorieId() ));
        }
        return $modele;
    }

    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setMontant($modele->getMontant());
        $dto->setSaisonId($modele->getSaisonId());
        $dto->setSaisonName($modele->getSaisonName());
        $dto->setCategorieId($modele->getCategorieId());
        $dto->setCategorieName($modele->getCategorieName());

        return $dto;
    }

}
