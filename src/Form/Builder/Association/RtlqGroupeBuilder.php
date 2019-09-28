<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqGroupeDTO;
use App\Entity\Association\RtlqGroupe;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Controller\Api\Association\AdherentController;
use App\Entity\Association\RtlqAdherent;
use App\Form\Dto\Association\RtlqAdherentDTO;

class RtlqGroupeBuilder extends AbstractRtlqBuilder
{
    private $rtlqAdherentBuilder;

    public function __construct()
    {
        $this->rtlqAdherentBuilder = new RtlqAdherentBuilder();
    }
    

    public function dtoToModele($em, $postModele, $modele)
    {
        $modele->setNom( $postModele->getNom () );
        $modele->setRole( $postModele->getRole () );
        $modele->removeAllAdherents();
        foreach ($postModele->getAdherents() as $adherentDto) {
            $modelAdh = $em->getReference ( RtlqAdherent::class, $adherentDto['id'] );
            $modele->addAdherent($modelAdh);
        }
        return $modele;
    }
    
    
    public function modeleToDto($modele, $dtoClass)
    {
        $dto = $this->getNewDto($dtoClass);

        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom() );
        $dto->setRole ( $modele->getRole() );

        foreach ($modele->getAdherents() as $adherent) {
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, RtlqAdherentDTO::class);
            $dto->addAdherent( $adherentDto );
        }
        
        return $dto;
    }
}
