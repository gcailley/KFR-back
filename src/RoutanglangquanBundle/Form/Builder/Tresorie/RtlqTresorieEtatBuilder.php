<?php

namespace RoutanglangquanBundle\Form\Builder\Tresorie;

use RoutanglangquanBundle\Form\Builder\AbstractRtlqEnumBuilder;
use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieEtatDTO;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat;

class RtlqTresorieEtatBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqTresorieEtat ();
	}
	protected function getDto() {
		return new RtlqTresorieEtatDTO ();
	}
}
