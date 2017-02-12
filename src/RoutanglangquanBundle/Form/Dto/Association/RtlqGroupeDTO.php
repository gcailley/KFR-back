<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqGroupeDTO extends AbstractRtlqDTO {
	
    protected $nom;
    protected $adherents;

    
    public function __construct() {
    	$this->$adherents = array();
    }
    public function getNom() {
        return $this->nom;
    }

    public function getAdherents() {
        return $this->adherents;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setAdherents($adherents) {
        $this->adherents = $adherents;
        return $this;
    }

    
    public function addAdherent($adherent) {
        $this->adherents[] = $adherent;
        return $this;
    }
}
