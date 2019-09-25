<?php

namespace App\Form\Builder;

use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Intl\Exception\NotImplementedException;

abstract class AbstractRtlqBuilder 
{

    abstract public function dtoToModele($em, $dto, $modele);
    
    abstract public function modeleToDto($modele, $dtoClass);
	
	public function modeleToDtoLight($modele, $dtoClass) {
		return $this->modeleToDto($modele, $dtoClass);
	}

    
    public function modelesToDtos($modeles, $dtoClass) {
    	$dto_array = array();
    	foreach ($modeles as $modele) {
    		$dto = $this->modeleToDto($modele, $dtoClass);
    		array_push($dto_array, $dto);
    	}
    	 return $dto_array;
    }
    
    protected function  dateToString($date) {
        
    	return $date==null ? null : $date->format('Y-m-d');
	}
	
	public function getNewDto($dtoClass) {
		return new $dtoClass;
	}
}
