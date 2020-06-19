<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqPhotoDTO;
use App\Entity\Association\RtlqPhoto;
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqPhotoBuilder extends AbstractRtlqBuilder
{

 

    public function dtoToModele($em, $dto, $modele)
    {

        $modele->setTitle( $dto->getTitle () );
        $modele->setDescription( $dto->getDescription () );
        $modele->setSourceBase64( $dto->getSource() );
        $modele->setRepertoire( $em->getReference ( RtlqPhotoDirectory::class, $dto->getRepertoireId () ) );

        return $modele;
    }

        
    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
		$dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setTitle ( $modele->getTitle() );
        $dto->setDescription ( $modele->getDescription() );
        $dto->setRepertoireId ( $modele->getRepertoire()->getId());
        $dto->setRepertoireName ( $modele->getRepertoire()->getName());
		
		return $dto;
    }
}
