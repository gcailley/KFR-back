<?php

namespace RoutanglangquanBundle\Form\Builder\Tresorie;

use RoutanglangquanBundle\Form\Builder\AbstractRtlqEnumBuilder;
use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieCategorieDTO;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;

class RtlqTresorieCategorieBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqTresorieCategorie ();
	}
	protected function getDto() {
		return new RtlqTresorieCategorieDTO ();
	}
}
