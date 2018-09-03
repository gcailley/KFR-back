<?php

namespace App\Form\Builder\Saison;

use App\Form\Dto\Saison\RtlqSaisonDTO;
use App\Entity\Saison\RtlqSaison;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Form\Builder\Association\RtlqAdherentBuilder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Controller\Api\Association\AdherentController;

class RtlqSaisonBuilder extends AbstractRtlqBuilder
{

     private $rtlqAdherentBuilder;
     public function __construct()
     {
         $this->rtlqAdherentBuilder = new RtlqAdherentBuilder(null);
     }
        
    public function dtoToModele($em, $postModele, $modele, $controller)
    {
        $modele->setNom( $postModele->getNom () );
        $modele->setDateDebut ( $postModele->getDateDebut () );
        $modele->setDateFin ( $postModele->getDateFin () );
        $modele->setActive($postModele->getActive() );


        $modele->removeAllAdherents();
        foreach ($postModele->getAdherents() as $adherentDto) {
            // TODO changer le nom qui est en dur
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
        $dto->setDateDebut( $this->dateToString ( $modele->getDateDebut () ) );
        $dto->setDateFin( $this->dateToString ( $modele->getDateFin () ) );
        $dto->setActive( $modele->getActive() );

        // TODO suppression des controller dans les builder c'est naze
        $adherentController = new AdherentController(null, null);
        foreach ($modele->getAdherents() as $adherent) {
            $adherentDto = $this->rtlqAdherentBuilder->modeleToDtoLight($adherent, $adherentController);
            $dto->addAdherent( $adherentDto );
        }
        
        return $dto;
    }
}
