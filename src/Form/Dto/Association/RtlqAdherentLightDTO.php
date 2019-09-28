<?php

namespace App\Form\Dto\Association;
use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAdherentLightDTO extends AbstractRtlqDTO {

    protected $nom;

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    protected $prenom;

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }
    
    public function jsonSerialize() {
		$vars = get_object_vars ( $this );	
		return $vars;
	}

    
}

