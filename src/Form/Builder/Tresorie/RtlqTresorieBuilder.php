<?php

namespace App\Form\Builder\Tresorie;

use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use App\Entity\Tresorie\RtlqTresorieEtat;
use App\Entity\Saison\RtlqSaison;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Cotisation\RtlqCotisation;

class RtlqTresorieBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $postModele, $modele)
    {
        $modele->setDescription ( $postModele->getDescription () );
        $modele->setResponsable ( $postModele->getResponsable () );
        $modele->setAdherentName ( $postModele->getAdherentName () );
        $modele->setDateCreation ( $postModele->getDateCreation () );
        $modele->setMontant ( $postModele->getMontant () );
        $modele->setCheque ( $postModele->getCheque () );
        $modele->setPointe ( $postModele->getPointe () );
        $modele->setNumeroCheque ( $postModele->getNumeroCheque () );
        $modele->setNumeroRemiseCheque ( $postModele->getNumeroRemiseCheque () );
        
        $modele->setEtat ( $em->getReference(RtlqTresorieEtat::class, $postModele->getEtatId ()));
        $modele->setCategorie ( $em->getReference ( RtlqTresorieCategorie::class, $postModele->getCategorieId () ) );
        $modele->setSaison ( $em->getReference ( RtlqSaison::class, $postModele->getSaisonId () ) );
        if ($postModele->getAdherentId () != null) {
            $modele->setAdherent ( $em->getReference ( RtlqAdherent::class, $postModele->getAdherentId() ) );
        } else {
            $modele-> setAdherent (null);
        }
                
        return $modele;
    }
    
    
    public function modeleToDto($modele,  $dtoClass)
    {
		$dto = $this->getNewDto($dtoClass);
        
        $dto->setId ( $modele->getId () );
        $dto->setDescription ( $modele->getDescription () );
        $dto->setResponsable ( $modele->getResponsable () );
        $dto->setAdherentName ( $modele->getAdherentName () );
        $dto->setDateCreation ( $this->dateToString ( $modele->getDateCreation () ) );
        $dto->setMontant ( $modele->getMontant () );
        $dto->setCheque ( $modele->getCheque () );
        $dto->setPointe ( $modele->getPointe () );
        $dto->setNumeroCheque ( $modele->getNumeroCheque () );
        $dto->setNumeroRemiseCheque ( $modele->getNumeroRemiseCheque () );
        
        $dto->setEtatId ( $modele->getEtatId () );
        $dto->setEtatName ( $modele->getEtatName () );
        $dto->setCategorieId ( $modele->getCategorieId () );
        $dto->setCategorieName ( $modele->getCategorieNom() );
        $dto->setSaisonId ( $modele->getSaisonId () );
        $dto->setSaisonName ( $modele->getSaisonNom() );
        $dto->setAdherentId ( $modele->getAdherentId () );
                
        return $dto;
    }

    public static function createTresorieByCotisation(RtlqAdherent $adherent, $responsable, $doctrine) {
        $cotisationModele = $adherent->getCotisation();
        $cotisations = $cotisationModele->getRepertitionChequeAsArray();
        $annuel = ($cotisationModele->getCategorie()->getId() == RtlqTresorieCategorie::COTISATION_ANNUELLE)?true:false;
        $now = new \DateTime('NOW');
        $debutSaison = $cotisationModele->getSaison()->getDateDebut();
        $dateTrimestre =  [(clone $debutSaison)->modify('+0 month'), (clone $debutSaison)->modify('+3 month'), (clone $debutSaison)->modify('+6 month')];
        $dateAnnuelle =  [(clone $now)->modify('+1 month'), (clone $now)->modify('+2 month'), (clone $now)->modify('+3 month')];

        $iteration = 0;
        $iterationMax = sizeof($cotisations);
        $tresories = [];
        foreach ($cotisations as $key => $value) {
            if ($annuel) {
                $description = 'Cotisation annuelle';
                $date = $dateAnnuelle;
            } else {
                $description = 'Cotisation trimestrielle';
                $date = $dateTrimestre;
            }

            //creation d'une tresorie
            $newTresorie = new RtlqTresorie();
            $newTresorie->setResponsable($responsable);
            $newTresorie->setAdherentName($adherent->getPrenomNom());
            $newTresorie->setAdherent($adherent);
            $newTresorie->setCategorie($cotisationModele->getCategorie());
            $newTresorie->setCheque(true);
            //TODO mettre le TODO automatique en fonction du mois
            $newTresorie->setNumeroCheque("TODO");
            $newTresorie->setDateCreation($date[$iteration]);
            $newTresorie->setDescription( sprintf("%s %d - %s", $description, $iteration+1, $adherent->getPrenomNom()));
            $etat = $doctrine->getRepository(RtlqTresorieEtat::class)->findOneBy(array("id"=>RtlqTresorieEtat::A_RECLAMER), null, 1 , null);
            $newTresorie->setEtat($etat);
            $newTresorie->setSaison($cotisationModele->getSaison());
            $newTresorie->setMontant($value);
            array_push($tresories, $newTresorie);
            $iteration++;
        }
        return $tresories;
    }


    public static function createTresorieByLicence(RtlqAdherent $adherent, $responsable, $licenceCotisation, $doctrine) {
        $now = new \DateTime('NOW');
        $description = 'Licence annuelle';

        //creation d'une tresorie
        $newTresorie = new RtlqTresorie();
        $newTresorie->setResponsable($responsable);
        $newTresorie->setAdherentName($adherent->getPrenomNom());
        $newTresorie->setAdherent($adherent);
        $newTresorie->setCategorie($licenceCotisation->getCategorie());
        $newTresorie->setCheque(true);
        //TODO mettre le TODO automatique en fonction du mois
        $newTresorie->setNumeroCheque("TODO");
        $newTresorie->setDateCreation($now);
        $newTresorie->setDescription(sprintf("%s - %s", $description, $adherent->getPrenomNom()));
        $etat = $doctrine->getRepository(RtlqTresorieEtat::class)->findOneBy(array("id"=>RtlqTresorieEtat::A_RECLAMER), null, 1, null);
        $newTresorie->setEtat($etat);
        $newTresorie->setSaison($licenceCotisation->getSaison());
        $newTresorie->setMontant($licenceCotisation->getCotisation());

        return $newTresorie;
    }

    public static function createTresorieByLicenceDeduction(RtlqAdherent $adherent, $responsable, $licenceCotisation, $doctrine) {
        $now = new \DateTime('NOW');
        $description = 'Reduction sur Licence annuelle';

        //creation d'une tresorie
        $newTresorie = new RtlqTresorie();
        $newTresorie->setResponsable($responsable);
        $newTresorie->setAdherentName($adherent->getPrenomNom());
        $newTresorie->setAdherent($adherent);
        $newTresorie->setCategorie($licenceCotisation->getCategorie());
        $newTresorie->setCheque(true);
        //TODO mettre le TODO automatique en fonction du mois
        $newTresorie->setNumeroCheque("TODO");
        $newTresorie->setDateCreation($now);
        $newTresorie->setDescription(sprintf("%s - %s", $description, $adherent->getPrenomNom()));
        $etat = $doctrine->getRepository(RtlqTresorieEtat::class)->findOneBy(array("id"=>RtlqTresorieEtat::A_RECLAMER), null, 1, null);
        $newTresorie->setEtat($etat);
        $newTresorie->setSaison($licenceCotisation->getSaison());
        $newTresorie->setMontant(1 - sizeof($adherent->getSaisons()));

        return $newTresorie;
    }

    
}
