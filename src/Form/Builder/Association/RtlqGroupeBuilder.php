<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqGroupeDTO;
use App\Entity\Association\RtlqGroupe;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use App\Controller\Api\Association\AdherentController;

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
        $modele->removeAllAdherents();
        foreach ($postModele->getAdherents() as $adherentDto) {
            //TODO ne plus mettre les noms c'est naze
            $modelAdh = $em->getReference ( "App\Entity\Association\RtlqAdherent", $adherentDto['id'] );
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

        // TODO suppression des controller dans les builder c'est naze
        $adherentController = new AdherentController(null, null);
        foreach ($modele->getAdherents() as $adherent) {
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, $adherentController);
            $dto->addAdherent( $adherentDto );
        }
        
        return $dto;
    }
}
