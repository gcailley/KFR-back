<?php

namespace App\Form\Builder\Association;

use App\Controller\Api\Association\AdherentController;
use App\Form\Dto\Association\RtlqAdherentDTO;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Association\RtlqGroupe;
use App\Form\Builder\AbstractRtlqBuilder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Entity\Kungfu\RtlqKungfuAdherentTao;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieEtat;

class RtlqAdherentBuilder extends AbstractRtlqBuilder
{


    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder = null)
    {
        $this->encoder = $encoder;
    }

    public function encodePassword($modele, $pwd)
    {
        if ($this->encoder != null) {
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $this->encoder->encodePassword($modele, $pwd);
            return $encoded;
        } else {
            return null;
        }
    }

    public function dtoToModele($em, $dto, $modele)
    {

        $modele->setUsername($dto->getUsername());
        $modele->setEmail($dto->getEmail());
        $modele->setTelephone($dto->getTelephone());
        $modele->setNom($dto->getNom());
        $modele->setPrenom($dto->getPrenom());
        $modele->setDateNaissance($dto->getDateNaissance());
        $modele->setActif($dto->getActif());
        $modele->setPublic($dto->getPublique());
        $modele->setAdresse($dto->getAdresse());
        $modele->setCodePostal($dto->getCodePostal());
        $modele->setVille($dto->getVille());
        $modele->setAvatar($dto->getAvatar());
        $modele->setAvatarName($dto->getAvatarUri());
        $modele->setDateCreation($dto->getDateCreation());
        if ($dto->getDateLastAuth() != null) {
            $modele->setDateLastAuth($dto->getDateLastAuth());
        }
        $modele->setLicenceNumber($dto->getLicenceNumber());
        $modele->setLicenceEtat($dto->getLicenceEtat());
        $modele->setForumUid($dto->getForumUid());
        $modele->setForumUsername($dto->getForumUsername());


        foreach ($dto->getGroupes() as $groupeId) {
            $modele->addGroupe($em->getReference(RtlqGroupe::class, $groupeId));
        }
        foreach ($dto->getTaos() as $taoId) {
            $modele->addTao($em->getReference(RtlqKungfuAdherentTao::class, $taoId));
        }

        foreach ($dto->getTresories() as $tresorieId) {
            $modele->addTresorie($em->getReference(RtlqTresorie::class, $tresorieId));
        }

        foreach ($dto->getCotisations() as $cotisationId) {
            $modele->addCotisation($em->getReference(RtlqCotisation::class, $cotisationId));
        }
        if ($dto->getCotisationId() != null) {
            $modele->addCotisation($em->getReference(RtlqCotisation::class, $dto->getCotisationId()));
        } else {
            $modele->removeCotisationSaisonCourante();
        }

        if ($dto->getPwd() != null) {
            $encoded = $this->encodePassword($modele, $dto->getPwd());
            $modele->setPassword($encoded);
        }


        return $modele;
    }


    public function modeleToDtoSuperLight($modele, $dtoClass, $doctrine)
    {
        $dto = new $dtoClass;

        $dto->setId($modele->getId());
        $dto->setPwd(null);
        $dto->setNom($modele->getNom());
        $dto->setPrenom($modele->getPrenom());
        if ("resource" === gettype($modele->getAvatar())) {
            $dto->setAvatar(stream_get_contents($modele->getAvatar()));
        } else {
            $dto->setAvatar($modele->getAvatar());
        }
        if ($modele->getAvatarName() != null) {
            $dto->setAvatarUri($modele->getAvatarName());
        } else {
            $dto->setAvatarUri(AdherentController::URI_AVATAR . '_default_.jpeg');
        }
        return $dto;
    }

    public function modeleToDtoLight($modele, $dtoClass, $doctrine)
    {
        $dto = $this->modeleToDtoSuperLight($modele, $dtoClass, $doctrine);
        $dto->setEmail($modele->getEmail());
        $dto->setUsername($modele->getUsername());
        // pour des raisons de sécurité ne doit pas être présent
        $dto->setTelephone($modele->getTelephone());
        $dto->setDateNaissance($this->dateToString($modele->getDateNaissance()));
        $dto->setActif($modele->getActif());
        $dto->setPublique($modele->getPublic());
        $dto->setSaisonCourante($modele->isInSaisonCourante());
        $dto->setAdresse($modele->getAdresse());
        $dto->setCodePostal($modele->getCodePostal());
        $dto->setVille($modele->getVille());
        $dto->setDateCreation($this->dateToString($modele->getDateCreation()));
        $dto->setDateLastAuth($this->dateToString($modele->getDateLastAuth()));
        $dto->setLicenceNumber($modele->getLicenceNumber());
        $dto->setLicenceEtat($modele->getLicenceEtat());
        $dto->setForumUid($modele->getForumUid());
        $dto->setForumUsername($modele->getForumUsername());
        return $dto;
    }


    public function ofuscated($modeles, $dtoClass)
    {
        $dto_array = array();
        foreach ($modeles as $modele) {
            $dto = new $dtoClass;

            $dto->setTelephone($modele->getTelephone());
            $dto->setNom($modele->getNom());
            $dto->setPrenom($modele->getPrenom());
            $dto->setDateNaissance($this->dateToString($modele->getDateNaissance()));
            $dto->setActif($modele->getActif());
            $dto->setPublique($modele->getPublic());
            $dto->setAdresse($modele->getAdresse());
            $dto->setCodePostal($modele->getCodePostal());
            $dto->setVille($modele->getVille());
            if ($modele->getAvatarName() != null) {
                $dto->setAvatarUri($modele->getAvatarName());
            } else {
                $dto->setAvatarUri(AdherentController::URI_AVATAR . '_default_.jpeg');
            }

            if (!$dto->getPublique()) {
                $dto->setTelephone("#####################");
                $dto->setAdresse("#####################");
                $dto->setCodePostal("#####################");
            }
            array_push($dto_array, $dto);
        }
        return $dto_array;
    }


    public function modeleToDto($modele, $dtoClass, $doctrine)
    {
        $dto = $this->modeleToDtoLight($modele, $dtoClass, $doctrine);
        if ($modele->getGroupes() != null) {
            foreach ($modele->getGroupes() as $groupe) {
                $dto->addGroupe($groupe->getId());
            }
        }

        if ($modele->getTaos() != null) {
            foreach ($modele->getTaos() as $tao) {
                $dto->addTao($tao->getId());
            }
        }

        foreach ($modele->getCotisations() as $cotisations) {
            $dto->addCotisation($cotisations->getId());
        }
        $cotisationSaisonCourante = $modele->getCotisationSaisonCourante();
        if (null != $cotisationSaisonCourante) {
            $dto->setCotisationId($cotisationSaisonCourante->getId());
            $dto->setCotisationName($cotisationSaisonCourante->getName());
        }


        if ($modele->getTresories() != null) {
            $totalEncaisser = 0;
            $totalPrevisionnel = 0;
            $totalEnRetard = 0;
            $now = new \DateTime('NOW');

            foreach ($modele->getTresories() as $tresorie) {
                $dto->addTresorie($tresorie->getId());
                if (RtlqTresorieEtat::ENCAISSE === $tresorie->getEtat()->getId() || RtlqTresorieEtat::REGLER === $tresorie->getEtat()->getId()) {
                    $totalEncaisser += $tresorie->getMontant();
                } else if (RtlqTresorieEtat::A_ENCAISSER === $tresorie->getEtat()->getId() || RtlqTresorieEtat::A_RECLAMER === $tresorie->getEtat()->getId()) {
                    $totalPrevisionnel += $tresorie->getMontant();
                    //                    dump($tresorie);
                    if (RtlqTresorieEtat::A_RECLAMER === $tresorie->getEtat()->getId() && $now > $tresorie->getDateCreation()) {
                        $totalEnRetard += $tresorie->getMontant();
                    }
                }
                //                dump($totalEncaisser . '/' . $totalPrevisionnel . '/' . $totalEnRetard);
            }

            $dto->addMontantTotalEncaisse($totalEncaisser);
            $dto->addMontantTotalPrevisionnel($totalPrevisionnel);
            $dto->addMontantTotalEnRetard($totalEnRetard);
        }

        return $dto;
    }
}
