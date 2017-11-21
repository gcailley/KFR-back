<?php

namespace RoutanglangquanBundle\Form\Builder\Kungfu;

use RoutanglangquanBundle\Form\Builder\AbstractRtlqEnumBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqKungfuStyleDTO;
use RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuStyle;

class RtlqKungfuStyleBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqKungfuStyle ();
	}
}
