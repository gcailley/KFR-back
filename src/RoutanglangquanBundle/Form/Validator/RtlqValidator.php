<?php

namespace RoutanglangquanBundle\Form\Validator;

class RtlqValidator {
	function doPostValidate($dto, $entity) {
		return null;
	}
	function doPutValidate($dto, $entity) {
		return $this->doPostValidate($dto, $entity);
	}
}
