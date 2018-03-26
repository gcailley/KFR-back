<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use RoutanglangquanBundle\Entity\Association\RtlqPhotoDirectory;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqPhotoDirectoryBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setName( $postModele->getName () );

        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setName ( $modele->getName() );
		
		return $dto;
    }
}
