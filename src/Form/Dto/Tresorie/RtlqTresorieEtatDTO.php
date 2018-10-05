<?php

namespace App\Form\Dto\Tresorie;

use App\Form\Dto\AbstractRtlqEnumDTO;

class RtlqTresorieEtatDTO extends AbstractRtlqEnumDTO {
    public $next_etat_id;
    public $next_etat_name;


    public function setNextEtatId($value) {
		$this->next_etat_id = $value;
		return $this;
	}
	public function getNextEtatId() {
		return $this->next_etat_id;
	}

    public function setNextEtatName($value) {
		$this->next_etat_name = $value;		
		return $this;
	}
	public function getNextEtatName() {
		return $this->next_etat_name;
	}

}