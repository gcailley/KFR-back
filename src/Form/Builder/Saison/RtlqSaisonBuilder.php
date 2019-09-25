<?php

namespace App\Form\Builder\Saison;

use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Controller\Api\Association\AdherentController;
use App\Form\Dto\Association\RtlqAdherentDTO;

class RtlqSaisonBuilder extends AbstractRtlqBuilder
{
    private $rtlqAdherentBuilder;
    private $withAdherents = false;

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

        $modele->removeAllAdherents();
        foreach ($postModele->getAdherents() as $adherentDto) {
            // TODO changer le nom qui est en dur
            $modelAdh = $em->getReference(RtlqAdherent::class, $adherentDto['id']);
            $modele->addAdherent($modelAdh);
        }

        return $modele;
    }

    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setNom($modele->getNom());
        $dto->setDateDebut($this->dateToString($modele->getDateDebut()));
        $dto->setDateFin($this->dateToString($modele->getDateFin()));
        $dto->setActive($modele->getActive());

        if ($this->withAdherents) {
            foreach ($modele->getAdherents() as $adherent) {
                $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, RtlqAdherentDTO::class);
                $dto->addAdherent($adherentDto);
            }
        }

        return $dto;
    }
}
