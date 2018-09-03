<?php

namespace App\Form\Validator;

class RtlqValidator {

	function doPostValidateDto($dto) {
		return null;
	}
	function doPutValidateDto($dto) {
		return $this->doPostValidateDto($dto);
	}

}
