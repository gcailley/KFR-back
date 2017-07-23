<?php

namespace RoutanglangquanBundle\Form\Builder\Association;

use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;

class RtlqAdherentBuilder extends AbstractRtlqBuilder {

    public function dtoToModele($em, $postModele) {
        $modele = new RtlqAdherent ();

        $modele->setId($postModele->getId());
        $modele->setEmail($postModele->getEmail());
        $modele->setPwd($postModele->getPwd());
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
        $modele->setDateLastAuth($postModele->getDateLastAuth());
        $modele->setLicenceNumber($postModele->getLicenceNumber());
        $modele->setLicenceEtat($postModele->getLicenceEtat());


        foreach ($postModele->getGroupes() as $groupeId) {
            $modele->addGroupe($em->getReference("RoutanglangquanBundle\Entity\Association\RtlqGroupe", $groupeId()));
        }
        foreach ($postModele->getCotisations() as $cotisationId) {
            $modele->addCotisation($em->getReference("RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation", $cotisationId()));
        }
        foreach ($postModele->getTresories() as $tresorieId) {
            $modele->addTresorie($em->getReference("RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie", $tresorieId()));
        }
        return $modele;
    }

    public function modeleToDto($modele) {
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


        if ($modele->getGroupes() != null) {
            foreach ($modele->getGroupes() as $groupe) {
                $dto->addGroupe($groupe->getId());
            }
        }

        if ($modele->getCotisations() != null) {
            foreach ($modele->getCotisations() as $cotisation) {
                $dto->addCotisation($cotisation->getId());
            }
        }
        if ($modele->getTresories() != null) {
            foreach ($modele->getTresories() as $tresorie) {
                $dto->addTresorie($tresorie->getId());
            }
        }

        return $dto;
    }

}
