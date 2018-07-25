<?php

namespace RoutanglangquanBundle\Form\Builder\Saison;

use RoutanglangquanBundle\Form\Dto\Saison\RtlqSaisonDTO;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;

class RtlqSaisonBuilder extends AbstractRtlqBuilder
{

     private $rtlqAdherentBuilder;
     public function __construct()
     {
         $this->rtlqAdherentBuilder = new RtlqAdherentBuilder();
     }
        
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele->setNom( $postModele->getNom () );
        $modele->setDateDebut ( $postModele->getDateDebut () );
        $modele->setDateFin ( $postModele->getDateFin () );
        $modele->setActive($postModele->getActive() );


        $modele->removeAllAdherents();
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
        $dto->setDateDebut( $this->dateToString ( $modele->getDateDebut () ) );
        $dto->setDateFin( $this->dateToString ( $modele->getDateFin () ) );
        $dto->setActive( $modele->getActive() );

        
        $adherentController = $controller->getController('routanglangquanbundle.adherent_controller');
        foreach ($modele->getAdherents() as $adherent) {
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, $adherentController);
            $dto->addAdherent( $adherentDto );
        }
        
        return $dto;
    }
}
