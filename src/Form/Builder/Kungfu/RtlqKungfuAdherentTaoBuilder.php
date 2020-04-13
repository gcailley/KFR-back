<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Association\RtlqAdherent;
use App\Entity\Kungfu\RtlqKungfuAdherentTao;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuAdherentTaoDTO;

class RtlqKungfuAdherentTaoBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele)
    {

        $modele->setNiveau ( $dto->getNiveau () );
        $modele->setNbRevision ( $dto->getNbRevision () );
        $modele->setAnneeApprentissage( $dto->getAnneeApprentissage() );
        $modele->setDriveId( $dto->getDriveId() );
        $modele->setFavoris( $dto->getFavoris() );

        $modele->setTao($em->getReference ( RtlqKungfuTao::class, $dto->getTaoId ())) ;
        $modele->setAdherent($em->getReference ( RtlqAdherent::class, $dto->getAdherentId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto( $modele,  $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );

        $dto->setNiveau ( $modele->getNiveau () );
        $dto->setNbRevision ( $modele->getNbRevision () );
        $dto->setDriveId( $modele->getDriveId () );
        $dto->setAnneeApprentissage( $modele->getAnneeApprentissage() );
        $dto->setAdherentId( $modele->getAdherentId() );
        $dto->setFavoris( $modele->getFavoris() );
        
        $dto->setTaoId( $modele->getTaoId() );
        $dto->setPinyin( $modele->getTao()->getPinyin() );
        $dto->setNomChinois( $modele->getTao()->getNomChinois() );
        $dto->setStyleName( $modele->getTao()->getStyleName() );
        $dto->setTraduction( $modele->getTao()->getTraduction() );

        return $dto;
    }
}
