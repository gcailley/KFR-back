<?php

namespace RoutanglangquanBundle\Form\Dto\Cotisation;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqCotisationDTO extends AbstractRtlqDTO {

    protected $email;
    protected $pwd;
    protected $telephone;
    protected $nom;
    protected $prenom;
    protected $dateNaissance;
    protected $actif;
    protected $public;
    protected $adresse;
    protected $avatar;
    protected $codePostal;
    protected $ville;
    protected $dateCreation;
    protected $dateLastAuth;
    protected $groupesId;
    protected $cotisationsId;

    public function __construct() {
        $this->groupesId = array();
        $this->cotisationsId = array();
    }

    public function addGroupe($groupeId) {
        $this->groupesId[] = $groupeId;
        return $this;
    }

    public function addCotisation($cotisationId) {
        $this->$cotisationsId[] = $cotisationId;
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
        return $this->dateNaissance;
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
        return $this->codePostal;
    }

    public function getVille() {
        return $this->ville;
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function getDateLastAuth() {
        return $this->dateLastAuth;
    }

    public function getGroupesId() {
        return $this->groupesId;
    }

    public function getCotisationsId() {
        return $this->cotisationsId;
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

    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;
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

    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;
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

    public function setDateLastAuth($dateLastAuth) {
        $this->dateLastAuth = $dateLastAuth;
        return $this;
    }

    public function setGroupesId($groupesId) {
        $this->groupesId = $groupesId;
        return $this;
    }

    public function setCotisationsId($cotisationsId) {
        $this->cotisationsId = $cotisationsId;
        return $this;
    }

}
