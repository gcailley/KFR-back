<?php

namespace App\Form\Builder\Kungfu;

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

        $modele->setTao($em->getReference ( RtlqKungfuStyle::class, $postModele->getTaoId ())) ;
        $modele->setAdherent($em->getReference ( RtlqKungfuNiveau::class, $postModele->getAdherentId ())) ;

        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setNiveau ( $modele->getNiveau () );
        $dto->setNbRevision ( $modele->getNbRevision () );
        $dto->setAdherentId( $modele->getAdherentId() );
        $dto->setTaoId( $modele->getTaoId() );

        return $dto;
    }
}
