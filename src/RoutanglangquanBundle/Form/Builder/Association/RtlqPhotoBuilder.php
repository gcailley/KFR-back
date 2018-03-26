<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqPhotoDTO;
use RoutanglangquanBundle\Entity\Association\RtlqPhoto;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqPhotoBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $dto, $modele, $controller)
    {

        $modele->setTitle( $dto->getTitle () );
        $modele->setDescription( $dto->getDescription () );
        $modele->setSourceBase64( $dto->getSource() );
        $modele->setRepertoire( $em->getReference ( "RoutanglangquanBundle\Entity\Association\RtlqPhotoDirectory", $dto->getRepertoireId () ) );

        return $modele;
    }

        
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        
        $dto->setId ( $modele->getId () );
        $dto->setTitle ( $modele->getTitle() );
        $dto->setDescription ( $modele->getDescription() );
        $dto->setRepertoireId ( $modele->getRepertoire()->getId());
        $dto->setRepertoireName ( $modele->getRepertoire()->getName());
		
		return $dto;
    }
}
