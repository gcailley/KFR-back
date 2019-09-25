<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqPhotoDirectoryBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setName( $postModele->getNom () );

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
		$dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getName() );
		
		return $dto;
    }
}
