<?php

namespace App\Form\Builder\Saison;

use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Controller\Api\Association\AdherentController;
use App\Form\Dto\Association\RtlqAdherentDTO;

class RtlqSaisonBuilder extends AbstractRtlqBuilder
{

    public function __construct()
    {
        $this->rtlqAdherentBuilder = new RtlqAdherentBuilder(null);
    }

    public function dtoToModele($em, $postModele, $modele)
    {
        $modele->setNom($postModele->getNom());
        $modele->setDateDebut($postModele->getDateDebut());
        $modele->setDateFin($postModele->getDateFin());
        $modele->setActive($postModele->getActive());

        return $modele;
    }

    public function modeleToDtoLight($modele, $dtoClass, $doctrine)
    {
        $dto = $this->getNewDto($dtoClass);
        $dto->setId($modele->getId());
        $dto->setNom($modele->getNom());
        $dto->setActive($modele->getActive());

        return $dto;
    }
    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
        
        $dto = $this->modeleToDtoLight($modele, $dtoClass, $doctrine);
        $dto->setDateDebut($this->dateToString($modele->getDateDebut()));
        $dto->setDateFin($this->dateToString($modele->getDateFin()));

        $nb_adherents = 0;
        foreach ($modele->getCotisations() as $cotisation) {
            $nb_adherents += sizeof($cotisation->getAdherents());
        }

        $dto->setNbAdherents($nb_adherents);

        return $dto;
    }
}
