<?php

namespace App\Form\Builder\Association;

use App\Entity\Association\RtlqAdherent;
use App\Entity\Saison\RtlqSaison;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Saison\RtlqSaisonBuilder;
use App\Form\Dto\Saison\RtlqSaisonDTO;

class RtlqBureauBuilder extends AbstractRtlqBuilder
{

    
    private $rtlqSaisonBuilder;

    public function __construct()
    {
        $this->rtlqSaisonBuilder = new RtlqSaisonBuilder();
    }

    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setDateCreation($dto->getDateCreation()->setTime(12, 0, 0));
        $modele->setDateFin($dto->getDateFin()->setTime(12, 0, 0));
        $modele->setPresident($em->getReference(RtlqAdherent::class, $dto->getPresidentId()));
        $modele->setTresorier($em->getReference(RtlqAdherent::class, $dto->getTresorierId()));
        $modele->setSecretaire($em->getReference(RtlqAdherent::class, $dto->getSecretaireId()));

        $modele->removeAllSaisons();
        foreach ($dto->getSaisons() as $saisonDto) {
            $modeleSaison = $em->getReference(RtlqSaison::class, $saisonDto['id']);
            $modele->addSaison($modeleSaison);
        }
        return $modele;
    }


    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setDateCreation($this->dateToString($modele->getDateCreation()));
        $dto->setDateFin($this->dateToString($modele->getDateFin()));

        if ($modele->getPresident()) {
            $dto->setPresidentName($modele->getPresident()->getPrenomNom());
            $dto->setPresidentId($modele->getPresident()->getId());
        } 
        if ($modele->getTresorier()) {
            $dto->setTresorierName($modele->getTresorier()->getPrenomNom());
            $dto->setTresorierId($modele->getTresorier()->getId());
        } 
        if ($modele->getSecretaire()) {
            $dto->setSecretaireName($modele->getSecretaire()->getPrenomNom());
            $dto->setSecretaireId($modele->getSecretaire()->getId());
        } 

        foreach ($modele->getSaisons() as $saison) {
            if ($saison->getActive()) {
                $dto->setActif(true);
            }
            $saisonDto = $this->rtlqSaisonBuilder->modeleToDtoLight($saison, RtlqSaisonDTO::class, $doctrine);
            $dto->addSaison($saisonDto);
        }

        return $dto;
    }
}
