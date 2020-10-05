<?php

namespace App\Form\Builder\Kungfu;

class RtlqKungfuTaoReferentBuilder extends RtlqKungfuTaoBuilder
{
    public function dtoToModele($em, $dto, $modele)
    {
        $modele->setNbMoves($dto->getNbMoves());

        return $modele;
    }


    public function modeleToDto($modele, $dto, $doctrine )
    {
        return parent::modeleToDto($modele, $dto, $doctrine);
    }
}
