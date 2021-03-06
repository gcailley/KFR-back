<?php

namespace App\Form\Dto\Tresorie;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqTresorieDTO extends AbstractRtlqDTO {

    protected $description;
    protected $responsable;
    protected $adherent_name;
    protected $date_creation;
    protected $montant;
    protected $cheque;
    protected $numero_cheque;
    protected $numero_remise_cheque;
    protected $etat_id;
    protected $etat_name;
    protected $saison_id;
    protected $saison_name;
    protected $categorie_id;
    protected $categorie_name;
    protected $adherent_id;
    protected $pointe;

    /**
     * Set description
     *
     * @param string $description        	
     *
     * @return RtlqTresorie
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set responsable
     *
     * @param string $responsable        	
     *
     * @return RtlqTresorie
     */
    public function setResponsable($responsable) {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable() {
        return $this->responsable;
    }

    /**
     * Set adherent
     *
     * @param string $adherent        	
     *
     * @return RtlqTresorie
     */
    public function setAdherentName($adherent_name) {
        $this->adherent_name = $adherent_name;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return string
     */
    public function getAdherentName() {
        return $this->adherent_name;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation        	
     *
     * @return RtlqTresorie
     */
    public function setDateCreation($dateCreation) {
        $this->date_creation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation() {
        return $this->date_creation;
    }

    /**
     * Set montant
     *
     * @param float $montant        	
     *
     * @return RtlqTresorie
     */
    public function setMontant($montant) {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant() {
        return $this->montant;
    }

    /**
     * Set cheque
     *
     * @param integer $cheque        	
     *
     * @return RtlqTresorie
     */
    public function setCheque($cheque) {
        $this->cheque = $cheque;

        return $this;
    }

    /**
     * Get cheque
     *
     * @return integer
     */
    public function getCheque() {
        return $this->cheque;
    }

    /**
     * Set numeroCheque
     *
     * @param string $numeroCheque        	
     *
     * @return RtlqTresorie
     */
    public function setNumeroCheque($numero_cheque) {
        $this->numero_cheque = $numero_cheque;

        return $this;
    }

    /**
     * Get numeroCheque
     *
     * @return string
     */
    public function getNumeroCheque() {
        return $this->numero_cheque;
    }

    public function setNumeroRemiseCheque($value) {
        $this->numero_remise_cheque = $value;
        return $this;
    }
    public function getNumeroRemiseCheque() {
        return $this->numero_remise_cheque;
    }

    public function setEtatId($etatId) {
        $this->etat_id = $etatId;

        return $this;
    }


     /**
     * Set pointe
     *
     * @param string $pointe        	
     *
     * @return RtlqTresorie
     */
    public function setPointe($pointe) {
        $this->pointe = $pointe;

        return $this;
    }

    /**
     * Get numeroCheque
     *
     * @return string
     */
    public function getPointe() {
        return $this->pointe;
    }

    /**
     * Get etat
     */
    public function getEtatId() {
        return $this->etat_id;
    }



    public function setEtatName($etatName) {
        $this->etat_name = $etatName;

        return $this;
    }

    /**
     * Get etat
     */
    public function getEtatName() {
        return $this->etat_name;
    }

  

    public function setSaisonId($saisonId) {
        $this->saison_id = $saisonId;

        return $this;
    }

    /**
     * Get saison
     */
    public function getSaisonId() {
        return $this->saison_id;
    }

    /**
     * Set categorie
     *
     * @return RtlqTresorie
     */
    public function setCategorieId($categorieId) {
        $this->categorie_id = $categorieId;

        return $this;
    }

    /**
     * Get categorie
     */
    public function getCategorieId() {
        return $this->categorie_id;
    }

    public function getAdherentId() {
        return $this->adherent_id;
    }

    public function setAdherentId($adherent_id) {
        $this->adherent_id = $adherent_id;
        return $this;
    }

    

    public function getSaisonName() {
        return $this->saison_name;
    }

    public function getCategorieName() {
        return $this->categorie_name;
    }

    public function setSaisonName($saison_name) {
        $this->saison_name = $saison_name;
        return $this;
    }

    public function setCategorieName($categorie_name) {
        $this->categorie_name = $categorie_name;
        return $this;
    }


}
