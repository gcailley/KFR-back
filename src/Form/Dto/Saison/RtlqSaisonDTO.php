<?php

namespace App\Form\Dto\Saison;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqSaisonDTO extends AbstractRtlqDTO {
	
	protected $nom;
	protected $date_debut;
	protected $date_fin;
	protected $active;
    protected $nb_adherents = 0;

    
    public function __construct() {
    }

	
	/**
	 * Set nom
	 *
	 * @param string $nom        	
	 *
	 * @return RtlqTresorie
	 */
	public function setNom($nom) {
		$this->nom = $nom;
		
		return $this;
	}
	
	/**
	 * Get nom
	 *
	 * @return string
	 */
	public function getNom() {
		return $this->nom;
	}
	

	/**
	 * Set dateDebut
	 *
	 * @param \DateTime $dateCreation        	
	 *
	 * @return RtlqSaisonDto
	 */
	public function setDateDebut($dateDebut) {
		$this->date_debut = $dateDebut;
		
		return $this;
	}
	
	/**
	 * Get dateDebut
	 *
	 * @return \DateTime
	 */
	public function getDateDebut() {
		return $this->date_debut;
	}

	/**
	 * Set dateFin
	 *
	 * @param \DateTime $dateFin
	 *
	 * @return RtlqSaisonDto
	 */
	public function setDateFin($dateFin) {
		$this->date_fin = $dateFin;
	
		return $this;
	}
	
	/**
	 * Get dateFin
	 *
	 * @return \DateTime
	 */
	public function getDateFin() {
		return $this->date_fin;
	}
	
	
	
	/**
	 * Set active
	 *
	 * @param integer $active        	
	 *
	 * @return RtlqSaisonDto
	 */
	public function setActive($active) {
		$this->active = $active;
		
		return $this;
	}
	
	/**
	 * Get active
	 *
	 * @return integer
	 */
	public function getActive() {
		return $this->active;
	}
	


	public function setNbAdherents($nbAdherents) {
		$this->nb_adherents = $nbAdherents;
		return $this;
	}
	
	public function getNbAdherents() {
        return $this->nb_adherents;
    }
}
