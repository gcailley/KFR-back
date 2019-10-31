<?php

namespace App\Form\Builder\Kungfu;

use App\Entity\Association\RtlqAdherent;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\AbstractRtlqBuilder;

class RtlqKungfuAdherentTaoBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {

        $modele->setNiveau ( $postModele->getNiveau () );
        $modele->setNbRevision ( $postModele->getNbRevision () );
        $modele->setAnneeApprentissage( $postModele->getAnneeApprentissage() );

        $modele->setTao($em->getReference ( RtlqKungfuTao::class, $postModele->getTaoId ())) ;
        $modele->setAdherent($em->getReference ( RtlqAdherent::class, $postModele->getAdherentId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setNiveau ( $modele->getNiveau () );
        $dto->setNbRevision ( $modele->getNbRevision () );
        $dto->setAnneeApprentissage( $modele->getAnneeApprentissage() );
        $dto->setAdherentId( $modele->getAdherentId() );
        
        $dto->setTaoId( $modele->getTaoId() );
        $dto->setPinyin( $modele->getTao()->getPinyin() );
        $dto->setNomChinois( $modele->getTao()->getNomChinois() );
        $dto->setStyleName( $modele->getTao()->getStyleName() );
        $dto->setTraduction( $modele->getTao()->getTraduction() );
        

        return $dto;
    }
}
