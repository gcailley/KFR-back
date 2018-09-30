<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAdherentDTO extends AbstractRtlqDTO {

    protected $email;
    protected $pwd;
    protected $telephone;
    protected $username;
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
    protected $licence_number;
    protected $licence_etat;
    protected $forum_uid;
    protected $forum_username;
    protected $saisons;
    protected $groupes;
    protected $cotisation_id;
    protected $cotisation_name;
    protected $tresories;
    protected $montant_total_encaisse = 0;
    protected $montant_total_previsionnel = 0;
    protected $montant_total_en_retard = 0;
    protected $saison_courante = false;

    public function __construct() {
        $this->groupes = array();
        $this->tresories = array();
    }

    public function addGroupe($groupe) {
        $this->groupes[] = $groupe;
        return $this;
    }

    public function addTresorie($tresorie) {
        $this->tresories[] = $tresorie;
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

    public function getUsername() {
        return $this->username;
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
        return $this->date_creation;
    }

    public function getDateLastAuth() {
        return $this->date_last_auth;
    }

    public function getGroupes() {
        return $this->groupes;
    }

    public function getCotisationId() {
        return $this->cotisation_id;
    }

    public function setCotisationId($cotisation_id) {
        $this->cotisation_id = $cotisation_id;
        return $this;
    }

    public function getCotisationName() {
        return $this->cotisation_name;
    }

    public function setCotisationName($cotisation_name) {
        $this->cotisation_name = $cotisation_name;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    
    public function setUsername($value) {
        $this->username = $value;
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
        $this->date_creation = $dateCreation;
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

    public function setTresories($tresories) {
        $this->tresories = $tresories;
        return $this;
    }

    public function getTresories() {
        return $this->tresories;
    }

    public function getLicenceNumber() {
        return $this->licence_number;
    }

    public function getLicenceEtat() {
        return $this->licence_etat;
    }

    public function setLicenceNumber($licence_number) {
        $this->licence_number = $licence_number;
        return $this;
    }

    public function setLicenceEtat($licence_etat) {
        $this->licence_etat = $licence_etat;
        return $this;
    }

    public function getMontantTotalEncaisse() {
        return $this->montant_total_encaisse;
    }

    public function getMontantTotalPrevisionnel() {
        return $this->montant_total_previsionnel;
    }

    public function setMontantTotalEncaisse($montant_total_encaisse) {
        $this->montant_total_encaisse = $montant_total_encaisse;
        return $this;
    }

    public function setMontantTotalPrevisionnel($montant_total_previsionnel) {
        $this->montant_total_previsionnel = $montant_total_previsionnel;
        return $this;
    }

    public function addMontantTotalEncaisse($montant_total_encaisse) {
        $this->montant_total_encaisse += $montant_total_encaisse;
    }

    public function addMontantTotalPrevisionnel($montant_total_previsionnel) {
        $this->montant_total_previsionnel += $montant_total_previsionnel;
    }

    public function getMontantTotalEnRetard() {
        return $this->montant_total_en_retard;
    }

    public function setMontantTotalEnRetard($montant_total_en_retard) {
        $this->montant_total_en_retard = $montant_total_en_retard;
        return $this;
    }

    public function addMontantTotalEnRetard($montant_total_en_retard) {
        $this->montant_total_en_retard += $montant_total_en_retard;
        return $this;
    }


    public function getForumUid() {
        return $this->forum_uid;
    }
    public function setForumUid($value) {
        $this->forum_uid = $value;
        return $this;
    }

    public function getForumUsername() {
        return $this->forum_username;
    }
    public function setForumUsername($value) {
        $this->forum_username = $value;
        return $this;
    }

    public function getSaisons() {
        return $this->saisons;
    }
    public function setSaisons($values) {
        $this->saisons = $values;
        return $this;
    }
    public function addSaison($saison) {
        $this->saisons[] = $saison;
        return $this;
    }
    
    public function getSaisonCourante(){
        return $this->saison_courante;
    }
    public function setSaisonCourante($value) {
        $this->saison_courante = $value;
        return $this;
    }
    
}

