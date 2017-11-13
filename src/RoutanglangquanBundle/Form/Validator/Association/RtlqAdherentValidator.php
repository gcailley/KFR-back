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

namespace RoutanglangquanBundle\Form\Validator\Association;

use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Entity\Association\RtlqGroupe;
use RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie;
use RoutanglangquanBundle\Form\Validator\RtlqValidator;

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
