<?php

namespace RoutanglangquanBundle\Form\Builder\Kungfu;

use RoutanglangquanBundle\Form\Builder\AbstractRtlqEnumBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqKungfuNiveauDTO;
use RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuNiveau;

class RtlqKungfuNiveauBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqKungfuNiveau ();
	}
}
