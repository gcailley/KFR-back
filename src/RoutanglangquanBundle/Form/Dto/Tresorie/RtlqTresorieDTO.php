<?php

namespace RoutanglangquanBundle\Form\Dto\Tresorie;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

class RtlqTresorieDTO extends AbstractRtlqDTO {
	
	protected $description;
	protected $responsable;
	protected $adherent;
	protected $date_creation;
	protected $montant;
	protected $cheque;
	protected $numero_cheque;
	protected $etat_id;
	protected $saison_id;
	protected $categorie_id;
	
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
	public function setAdherent($adherent) {
		$this->adherent = $adherent;
		
		return $this;
	}
	
	/**
	 * Get adherent
	 *
	 * @return string
	 */
	public function getAdherent() {
		return $this->adherent;
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
	public function setEtatId($etatId) {
		$this->etat_id = $etatId;
		
		return $this;
	}
	/**
	 * Get etat
	 */
	public function getEtatId() {
		return $this->etat_id;
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
}
