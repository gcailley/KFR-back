<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Dto\Kungfu\RtlqKungfuTaoProfDTO;

class RtlqKungfuTaoProfBuilder extends RtlqKungfuTaoBuilder
{
    public function dtoToModele($em, $postModele, $modele): RtlqKungfuTao
    {
        $modele = parent::dtoToModele($em, $postModele, $modele);
        $modele->setVideoUrl($postModele->getVideoUrl());

        return $modele;
    }


    public function modeleToDto($modele, $dtoClass): RtlqKungfuTaoDTO
    {
        $dto = parent::modeleToDto($modele, $dtoClass);
        $dto->setVideoUrl($modele->getVideoUrl());

        return $dto;
    }
}
