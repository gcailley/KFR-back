<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAssociationDTO extends AbstractRtlqDTO {

    protected $nom;
    protected $date_creation;
    protected $active;
    protected $siege_social;
    protected $email;

    public function getNom() {
        return $this->nom;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    public function getActive() {
        return $this->active;
    }

    public function getSiegeSocial() {
        return $this->siege_social;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setDateCreation($dateCreation) {
        $this->date_creation = $dateCreation;
        return $this;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function setSiegeSocial($siegeSocial) {
        $this->siege_social = $siegeSocial;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

}
