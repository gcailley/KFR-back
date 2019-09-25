<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuTaoBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setNom ( $postModele->getNom () );
        $modele->setNomChinois ( $postModele->getNomChinois () );
        $modele->setDescription( $postModele->getDescription () );
        $modele->setOrigine( $postModele->getOrigine () );
        $modele->setArme( $postModele->getArme() );
        $modele->setArmeUrl( $postModele->getArmeUrl() );
        $modele->setVideoUrl( $postModele->getVideoUrl() );
        $modele->setActif( $postModele->getActif() );
        $modele->setCombine( $postModele->getCombine() );

        $modele->setStyle($em->getReference ( RtlqKungfuStyle::class, $postModele->getStyleId ())) ;
        $modele->setNiveau($em->getReference ( RtlqKungfuNiveau::class, $postModele->getNiveauId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom () );
        $dto->setNomChinois ( $modele->getNomChinois () );
        $dto->setDescription( $modele->getDescription () );
        $dto->setOrigine( $modele->getOrigine () );
        $dto->setArme( $modele->getArme() );
        $dto->setArmeUrl( $modele->getArmeUrl() );
        $dto->setVideoUrl( $modele->getVideoUrl() );
        $dto->setStyleId( $modele->getStyleId() );
        $dto->setStyleName( $modele->getStyleName() );
        $dto->setNiveauId( $modele->getNiveauId() );
        $dto->setNiveauName( $modele->getNiveauName() );
        $dto->setActif( $modele->getActif() );
        $dto->setCombine( $modele->getCombine() );

        return $dto;
    }
}
