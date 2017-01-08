<?php

namespace RoutanglangquanBundle\Form\Validator\Saison;

use RoutanglangquanBundle\Form\Validator\AbstractRtlqValidator;
use RoutanglangquanBundle\Form\Validator\RtlqValidator;

class RtlqSaisonValidator extends RtlqValidator {
	function doPostValidate($dto, $entity) {
		$errors = array();
		
		if ( $dto->getDateDebut() >= $dto->getDateFin()) {
			$errors[] = "Date de début sup. date de fin";
		}
		return $errors;
	}
	
}
