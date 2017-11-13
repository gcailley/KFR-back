<?php

namespace RoutanglangquanBundle\Form\Builder;

use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Intl\Exception\NotImplementedException;

abstract class AbstractRtlqBuilder 
{

    abstract public function dtoToModele($em, $postModele, $controller);
    
    abstract public function modeleToDto($modele);
	
	public function modeleToDtoLight($modele) {
		return $this->modeleToDto($modele);
	}

    
    public function modelesToDtos($modeles) {
    	$dto_array = array();
    	foreach ($modeles as $modele) {
    		$dto = $this->modeleToDto($modele);
    		array_push($dto_array, $dto);
    	}
    	 return $dto_array;
    }
    
    protected function  dateToString($date) {
        
    	return $date==null ? null : $date->format('Y-m-d');
    }
}
