<?php

namespace App\Form\Builder\Kungfu;
class RtlqKungfuTaoProfBuilder extends RtlqKungfuTaoBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {
        $modele = parent::dtoToModele($em, $postModele, $modele);
        $modele->setVideoUrl($postModele->getVideoUrl());

        return $modele;
    }


    public function modeleToDto($modele, $dtoClass, $doctrine )
    {
        $dto = parent::modeleToDto($modele, $dtoClass, $doctrine);
        $dto->setVideoUrl($modele->getVideoUrl());

        return $dto;
    }
}
