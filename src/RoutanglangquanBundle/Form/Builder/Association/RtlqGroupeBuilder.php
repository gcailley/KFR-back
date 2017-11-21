<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqGroupeDTO;
use RoutanglangquanBundle\Entity\Association\RtlqGroupe;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqGroupeBuilder extends AbstractRtlqBuilder
{
    private $rtlqAdherentBuilder;

    public function __construct()
    {
        $this->rtlqAdherentBuilder = new RtlqAdherentBuilder();
    }
    

    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setNom( $postModele->getNom () );
        $modele->setRole( $postModele->getRole () );
        foreach ($postModele->getAdherents() as $adherentDto) {
            $modelAdh = $em->getReference ( "RoutanglangquanBundle\Entity\Association\RtlqAdherent", $adherentDto['id'] );
            $modele->addAdherent($modelAdh);
        }
        return $modele;
    }
    
    
    public function modeleToDto($modele, $controller)
    {
        $dto = $controller->newDto();
        $dto->setId ( $modele->getId () );
        $dto->setNom ( $modele->getNom() );
        $dto->setRole ( $modele->getRole() );

        $adherentController = $controller->getController('routanglangquanbundle.adherent_controller');
        foreach ($modele->getAdherents() as $adherent) {
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, $adherentController);
            $dto->addAdherent( $adherentDto );
        }
        
        return $dto;
    }
}
