<?php

namespace RoutanglangquanBundle\Form\Builder;

use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieDTO;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

abstract class AbstractRtlqEnumBuilder extends AbstractRtlqBuilder {
	abstract protected function getModele();
	abstract protected function getDto();
	
	public function dtoToModele($em, $postModel, $controller) {
		$modele = $this->getModele();
		
		$modele->setId ( $postModele->getId () );
		$modele->setValue($postModele->getValue() );
		
		return $modele;
	}
	
	
	public function modeleToDto($modele) {
		$dto = $this->getDto();
		
		$dto->setId ( $modele->getId () );
		$dto->setValue ( $modele->getValue() );
		
		return $dto;
	}
}
