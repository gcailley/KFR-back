<?php

namespace App\Form\Builder;

use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Intl\Exception\NotImplementedException;

abstract class AbstractRtlqBuilder 
{

    abstract public function dtoToModele($em, $postModele, $modele, $controller);
    
    abstract public function modeleToDto($modele, $controller);
	
	public function modeleToDtoLight($modele, $controller) {
		return $this->modeleToDto($modele, $controller);
	}

    
    public function modelesToDtos($modeles, $controller) {
    	$dto_array = array();
    	foreach ($modeles as $modele) {
    		$dto = $this->modeleToDto($modele, $controller);
    		array_push($dto_array, $dto);
    	}
    	 return $dto_array;
    }
    
    protected function  dateToString($date) {
        
    	return $date==null ? null : $date->format('Y-m-d');
    }
}
