<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqGroupeDTO extends AbstractRtlqDTO {
	
    protected $nom;
    protected $role;
    protected $adherents;
    protected $nb_adherents = 0;

    
    public function __construct() {
    	$this->adherents = [];
    }
    public function getNom() {
        return $this->nom;
    }
    public function getRole() {
        return $this->role;
    }


    public function getAdherents() {
        return $this->adherents;
    }
    
    public function addAdherent($adherent) {
        $this->adherents[] = $adherent;
        $this->nb_adherents = sizeof($this->adherents);
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
    public function setRole($value) {
        $this->role = $value;
        return $this;
    }

    public function setAdherents($adherents) {
        $this->adherents = $adherents;
        $this->nb_adherents = sizeof($this->adherents);
        return $this;
    }

    
    public function setNbAdherents($nb_adherents) {
        $this->nb_adherents = $nb_adherents;
        return $this;
    }

    public function getNbAdherents() {
        return $this->nb_adherents;
    }

}
