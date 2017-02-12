<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAdherentDTO extends AbstractRtlqDTO {

    protected $email;
    protected $pwd;
    protected $telephone;
    protected $nom;
    protected $prenom;
    protected $date_naissance;
    protected $actif;
    protected $public;
    protected $adresse;
    protected $avatar;
    protected $code_postal;
    protected $ville;
    protected $date_creation;
    protected $date_last_auth;
    protected $groupes;
    protected $cotisations;

    public function __construct() {
        $this->groupes = array();
        $this->cotisations = array();
    }

    public function addGroupe($groupe) {
        $this->groupes[] = $groupe;
        return $this;
    }

    public function addCotisation($cotisation) {
        $this->$cotisations[] = $cotisation;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPwd() {
        return $this->pwd;
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

    public function getPublic() {
        return $this->public;
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

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function getDateLastAuth() {
        return $this->date_last_auth;
    }

    public function getGroupes() {
        return $this->groupes;
    }

    public function getCotisations() {
        return $this->cotisations;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setPwd($pwd) {
        $this->pwd = $pwd;
        return $this;
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

    public function setPublic($public) {
        $this->public = $public;
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

    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function setDateLastAuth($date_last_auth) {
        $this->date_last_auth = $date_last_auth;
        return $this;
    }

    public function setGroupes($groupes) {
        $this->groupes = $groupes;
        return $this;
    }

    public function setCotisations($cotisations) {
        $this->cotisations = $cotisations;
        return $this;
    }

}
