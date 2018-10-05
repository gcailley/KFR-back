<?php

namespace App\Form\Dto;

use App\Form\Dto\AbstractRtlqDTO;

abstract class AbstractRtlqEnumDTO extends AbstractRtlqDTO {
	
	protected $nom;
	
	/**
	 * Set nom
	 *
	 * @param string $nom        	
	 *
	 * @return AbstractRtlqEnumDTO
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
	
}