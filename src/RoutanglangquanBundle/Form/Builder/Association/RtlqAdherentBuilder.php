<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqAdherentBuilder extends AbstractRtlqBuilder
{

    public function dtoToModele($em, $postModele, $controller)
    {
        $modele = new RtlqAdherent ();

        $modele->setId($postModele->getId());
        $modele->setUsername($postModele->getUsername());
        $modele->setEmail($postModele->getEmail());
        $modele->setTelephone($postModele->getTelephone());
        $modele->setNom($postModele->getNom());
        $modele->setPrenom($postModele->getPrenom());
        $modele->setDateNaissance($postModele->getDateNaissance());
        $modele->setActif($postModele->getActif());
        $modele->setPublic($postModele->getPublic());
        $modele->setAdresse($postModele->getAdresse());
        $modele->setCodePostal($postModele->getCodePostal());
        $modele->setVille($postModele->getVille());
        $modele->setAvatar($postModele->getAvatar());
        $modele->setDateCreation($postModele->getDateCreation());
        if ($postModele->getDateLastAuth()!=null) {
            $modele->setDateLastAuth($postModele->getDateLastAuth());
        }
        $modele->setLicenceNumber($postModele->getLicenceNumber());
        $modele->setLicenceEtat($postModele->getLicenceEtat());


        foreach ($postModele->getGroupes() as $groupeId) {
            $modele->addGroupe($em->getReference("RoutanglangquanBundle\Entity\Association\RtlqGroupe", $groupeId()));
        }
        if ($postModele->getCotisationId() != null) {
            $modele->setCotisation($em->getReference("RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation", $postModele->getCotisationId() ));
        }
        foreach ($postModele->getTresories() as $tresorieId) {
            $modele->addTresorie($em->getReference("RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie", $tresorieId()));
        }

        if ($postModele->getPwd() != null) {
            $encoder = $controller->getEncoder();
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($modele, $postModele->getPwd());
            $modele->setPassword($encoded);
        }


        return $modele;
    }

    public function modeleToDtoLight($modele)
    {
        $dto = new RtlqAdherentDTO ();

        $dto->setId($modele->getId());
        $dto->setEmail($modele->getEmail());
    // pour des raisons de sécurité ne doit pas être présent
        $dto->setPwd(null);
        $dto->setTelephone($modele->getTelephone());
        $dto->setNom($modele->getNom());
        $dto->setPrenom($modele->getPrenom());
        $dto->setDateNaissance($this->dateToString($modele->getDateNaissance()));
        $dto->setActif($modele->getActif());
        $dto->setPublic($modele->getPublic());

        $dto->setAdresse($modele->getAdresse());
        $dto->setCodePostal($modele->getCodePostal());
        $dto->setVille($modele->getVille());
        $dto->setAvatar($modele->getAvatar());
        $dto->setDateCreation($this->dateToString($modele->getDateCreation()));
        $dto->setDateLastAuth($this->dateToString($modele->getDateLastAuth()));
        $dto->setLicenceNumber($modele->getLicenceNumber());
        $dto->setLicenceEtat($modele->getLicenceEtat());
        return $dto;
    }
        

    public function modeleToDto($modele)
    {
        $dto = $this->modeleToDtoLight($modele);

        if ($modele->getGroupes() != null) {
            foreach ($modele->getGroupes() as $groupe) {
                $dto->addGroupe($groupe->getId());
            }
        }

        if ($modele->getCotisation() != null) {
            $dto->setCotisationId($modele->getCotisation()->getId());
        }
        
        if ($modele->getTresories() != null) {
            foreach ($modele->getTresories() as $tresorie) {
                $dto->addTresorie($tresorie->getId());
                $dto->addMontantTotalEncaisse($tresorie->getMontant());
                $dto->addMontantTotalPrevisionnel($tresorie->getMontant());
                $dto->addMontantTotalEnRetard($tresorie->getMontant());
            }
        }

        return $dto;
    }
}
