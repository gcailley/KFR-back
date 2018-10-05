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

class RtlqAdherentValidator extends RtlqValidator {

    public function hasCotisation(RtlqAdherent $adherent, RtlqCotisation $cotisation) {
        return $cotisation->isEquals($adherent->getCotisation());
    }

    public function hasGroupe(RtlqAdherent $adherent, RtlqGroupe $groupe) {
        return $groupe->isInto($adherent->getGroupes());
    }

    public function hasTresorie(RtlqAdherent $adherent, RtlqTresorie $tresorie) {
        return $tresorie->isInto($adherent->getTresories());
    }

}