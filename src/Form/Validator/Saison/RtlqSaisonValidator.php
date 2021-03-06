<?php

namespace App\Form\Validator\Saison;

use App\Form\Validator\RtlqValidator;

class RtlqSaisonValidator extends RtlqValidator {
	function doPostValidateDto($dto) {
		$errors = array();
		if ( $dto->getDateDebut() >= $dto->getDateFin()) {
			$errors[] = "Date de début ".$dto->getDateDebut()->format('Y-m-d H:i:s')." est sup. à la date de fin ".$dto->getDateFin()->format('Y-m-d H:i:s');
		}
		return $errors;
	}
	
}
