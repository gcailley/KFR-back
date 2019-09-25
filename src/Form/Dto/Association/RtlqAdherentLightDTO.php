<?php

namespace App\Form\Dto\Association;

/**
 * @author GREGORY
 *
 */
class RtlqAdherentLightDTO implements \JsonSerializable {

    protected $telephone;
    protected $nom;
    protected $prenom;
    protected $date_naissance;
    protected $actif;
    protected $publique;
    protected $adresse;
    protected $avatar;
    protected $code_postal;
    protected $ville;

    public function __construct() {
    }
    
    public function jsonSerialize() {
		$vars = get_object_vars ( $this );	
		return $vars;
	}

    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }
    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getDateNaissance() {
        return $this->date_naissance;
    }

    public function getActif() {
        return $this->actif;
    }

    public function getPublique() {
        return $this->publique;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getCodePostal() {
        return $this->code_postal;
    }

    public function getVille() {
        return $this->ville;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
        return $this;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }

    public function setDateNaissance($date_naissance) {
        $this->date_naissance = $date_naissance;
        return $this;
    }

    public function setActif($actif) {
        $this->actif = $actif;
        return $this;
    }

    public function setPublique($publique) {
        $this->publique = $publique;
        return $this;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        return $this;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
        return $this;
    }

    public function setCodePostal($code_postal) {
        $this->code_postal = $code_postal;
        return $this;
    }

    public function setVille($ville) {
        $this->ville = $ville;
        return $this;
    }
    
}

