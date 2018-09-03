<?php

namespace App\Form\Builder\Kungfu;

use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuTaoBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setNom ( $postModele->getNom () );
        $modele->setNomChinois ( $postModele->getNomChinois () );
        $modele->setDescription( $postModele->getDescription () );
        $modele->setArme( $postModele->getArme() );
        $modele->setArmeUrl( $postModele->getArmeUrl() );
        $modele->setVideoUrl( $postModele->getVideoUrl() );
        $modele->setActif( $postModele->getActif() );

        $modele->setStyle($em->getReference ( "App\Entity\Kungfu\RtlqKungfuStyle", $postModele->getStyleId ())) ;
        $modele->setNiveau($em->getReference ( "App\Entity\Kungfu\RtlqKungfuNiveau", $postModele->getNiveauId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
		$dto = $controller->newDto();
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom () );
        $dto->setNomChinois ( $modele->getNomChinois () );
        $dto->setDescription( $modele->getDescription () );
        $dto->setArme( $modele->getArme() );
        $dto->setArmeUrl( $modele->getArmeUrl() );
        $dto->setVideoUrl( $modele->getVideoUrl() );
        $dto->setStyleId( $modele->getStyleId() );
        $dto->setStyleName( $modele->getStyleName() );
        $dto->setNiveauId( $modele->getNiveauId() );
        $dto->setNiveauName( $modele->getNiveauName() );
        $dto->setActif( $modele->getActif() );

        return $dto;
    }
}
