<?php

namespace App\Form\Builder\Kungfu;

use App\Form\Builder\AbstractRtlqEnumBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuNiveauDTO;
use App\Entity\Kungfu\RtlqKungfuNiveau;

class RtlqKungfuNiveauBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqKungfuNiveau ();
	}
}
