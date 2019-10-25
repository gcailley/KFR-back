<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RtlqAdherentValidator
 *
 * @author GREGORY
 */

namespace App\Form\Validator\Association;

use App\Entity\Association\RtlqAdherent;
use App\Entity\Association\RtlqGroupe;
use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Tresorie\RtlqTresorie;
use App\Form\Validator\RtlqValidator;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Entity\Kungfu\RtlqKungfuAdherentTao;

class RtlqAdherentValidator extends RtlqValidator
{

    public function hasCotisation(RtlqAdherent $adherent, RtlqCotisation $cotisation)
    {
        return $cotisation->isEquals($adherent->getCotisation());
    }

    public function hasGroupe(RtlqAdherent $adherent, RtlqGroupe $groupe)
    {
        return $groupe->isInto($adherent->getGroupes());
    }

    public function hasTao(RtlqAdherent $adherent, RtlqKungfuTao $tao)
    {
        foreach ($adherent->getTaos() as $key => $value) {
            if( $value->getTao() == $tao) {
                return $value;
            }
        } 
        return null;
    }

    public function hasTresorie(RtlqAdherent $adherent, RtlqTresorie $tresorie)
    {
        return $tresorie->isInto($adherent->getTresories());
    }
}
