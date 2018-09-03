<?php

namespace App\Form\Dto;

use App\Form\Dto\AbstractRtlqDTO;

abstract class AbstractRtlqEnumDTO extends AbstractRtlqDTO {
	
	protected $value;
	
	/**
	 * Set value
	 *
	 * @param string $value        	
	 *
	 * @return AbstractRtlqEnumDTO
	 */
	public function setValue($value) {
		$this->value = $value;
		
		return $this;
	}
	
	/**
	 * Get value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
	
}