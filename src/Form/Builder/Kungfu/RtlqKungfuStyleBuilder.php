<?php

namespace App\Form\Builder\Kungfu;

use App\Form\Builder\AbstractRtlqEnumBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuStyleDTO;
use App\Entity\Kungfu\RtlqKungfuStyle;

class RtlqKungfuStyleBuilder extends AbstractRtlqEnumBuilder {
	protected function getModele() {
		return new RtlqKungfuStyle ();
	}
}
