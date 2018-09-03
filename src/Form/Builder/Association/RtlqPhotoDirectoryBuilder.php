<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqPhotoDirectoryBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setName( $postModele->getNom () );

        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getName() );
		
		return $dto;
    }
}
