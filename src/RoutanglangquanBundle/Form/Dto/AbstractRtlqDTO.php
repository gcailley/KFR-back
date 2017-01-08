<?php

namespace RoutanglangquanBundle\Form\Dto;


abstract class AbstractRtlqDTO implements \JsonSerializable {
	protected $id;
	/**
	 * Set id
	 *
	 * @param string $id        	
	 *
	 * @return RtlqTresorie
	 */
	public function setId($id) {
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}
	public function jsonSerialize() {
		$vars = get_object_vars ( $this );
		
		return $vars;
	}
}
