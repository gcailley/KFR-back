<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Association\RtlqAdherent;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Form\Dto\Association\RtlqAdherentDTO;

class RtlqKungfuTaoBuilder extends AbstractRtlqBuilder
{

    private $rtlqAdherentBuilder;

    public function __construct()
    {
        $this->rtlqAdherentBuilder = new RtlqAdherentBuilder();
    }
    
    public function dtoToModele($em, $dto, $modele): RtlqKungfuTao
    {

        $modele->setNom($dto->getNom());
        $modele->setNomChinois($dto->getNomChinois());
        $modele->setTraduction($dto->getTraduction());
        $modele->setPinyin($dto->getPinyin());
        $modele->setOrigine($dto->getOrigine());
        $modele->setArme($dto->getArme());
        $modele->setActif($dto->getActif());
        $modele->setCombine($dto->getCombine());
        $modele->setNbMoves($dto->getNbMoves());
        $modele->setReferenceDriveId($dto->getReferenceDriveId());

        $modele->setStyle($em->getReference(RtlqKungfuStyle::class, $dto->getStyleId()));
        $modele->setNiveau($em->getReference(RtlqKungfuNiveau::class, $dto->getNiveauId()));

        foreach ($dto->getReferents() as $referentDto) {
            $modelAdh = $em->getReference ( RtlqAdherent::class, $referentDto['id'] );
            $modele->addReferent($modelAdh);
        }

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
        $dto->setReferenceDriveId($modele->getReferenceDriveId());

        foreach ( $modele->getTaosLearnt() as $taoLearnt) {
            dump($taoLearnt->getAdherent());
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoSuperLight($taoLearnt->getAdherent(), RtlqAdherentDTO::class, $doctrine);
            $dto->addAdherent($adherentDto);
        }
        foreach ( $modele->getReferents() as $referent) {
            $referentDto = $this->rtlqAdherentBuilder->modeleToDtoSuperLight($referent, RtlqAdherentDTO::class, $doctrine);
            $dto->addReferent($referentDto);
        }
    
        return $dto;
    }
}
