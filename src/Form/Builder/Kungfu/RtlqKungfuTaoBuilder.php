<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuTaoBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele): RtlqKungfuTao
    {

        $modele->setNom($postModele->getNom());
        $modele->setNomChinois($postModele->getNomChinois());
        $modele->setTraduction($postModele->getTraduction());
        $modele->setPinyin($postModele->getPinyin());
        $modele->setOrigine($postModele->getOrigine());
        $modele->setArme($postModele->getArme());
        $modele->setActif($postModele->getActif());
        $modele->setCombine($postModele->getCombine());
        $modele->setNbMoves($postModele->getNbMoves());

        $modele->setStyle($em->getReference(RtlqKungfuStyle::class, $postModele->getStyleId()));
        $modele->setNiveau($em->getReference(RtlqKungfuNiveau::class, $postModele->getNiveauId()));

        return $modele;
    }


    public function modeleToDto($modele, $dtoClass, $doctrine): RtlqKungfuTaoDTO
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId($modele->getId());
        $dto->setNom($modele->getNom());
        $dto->setPinyin($modele->getPinyin());
        $dto->setNomChinois($modele->getNomChinois());
        $dto->setTraduction($modele->getTraduction());
        $dto->setOrigine($modele->getOrigine());
        $dto->setArme($modele->getArme());
        $dto->setStyleId($modele->getStyleId());
        $dto->setStyleName($modele->getStyleName());
        $dto->setNiveauId($modele->getNiveauId());
        $dto->setNiveauName($modele->getNiveauName());
        $dto->setActif($modele->getActif());
        $dto->setCombine($modele->getCombine());
        $dto->setNbMoves($modele->getNbMoves());
        $dto->setNbTaosLearnt(sizeof($modele->getTaosLearnt()));

        return $dto;
    }
}
