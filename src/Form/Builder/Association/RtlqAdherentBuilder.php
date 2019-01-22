<?php

namespace App\Form\Builder\Association;

use App\Form\Dto\Association\RtlqAdherentDTO;
use App\Entity\Association\RtlqAdherent;
use App\Form\Builder\AbstractRtlqBuilder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieEtat;

class RtlqAdherentBuilder extends AbstractRtlqBuilder
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder=null)
    {
        $this->encoder = $encoder;
    }

    public function encodePassword($modele, $pwd) {
        if ($this->encoder != null) {
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $this->encoder->encodePassword($modele, $pwd);
            return $encoded;
        } else {
            return null;
        }
    }

    public function dtoToModele($em, $postModele, $modele, $controller)
    {

        $modele->setUsername($postModele->getUsername());
        $modele->setEmail($postModele->getEmail());
        $modele->setTelephone($postModele->getTelephone());
        $modele->setNom($postModele->getNom());
        $modele->setPrenom($postModele->getPrenom());
        $modele->setDateNaissance($postModele->getDateNaissance());
        $modele->setActif($postModele->getActif());
        $modele->setPublic($postModele->getPublique());
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
        $modele->setForumUid($postModele->getForumUid());
        $modele->setForumUsername($postModele->getForumUsername());


        foreach ($postModele->getGroupes() as $groupeId) {
            $modele->addGroupe($em->getReference("App\Entity\Association\RtlqGroupe", $groupeId()));
        }

        if ($postModele->getCotisationId() != null) {
            $modele->setCotisation($em->getReference(RtlqCotisation::class, $postModele->getCotisationId() ));
        }
        
        foreach ($postModele->getTresories() as $tresorieId) {
            $modele->addTresorie($em->getReference("App\Entity\Tresorie\RtlqTresorie", $tresorieId()));
        }
        foreach ($postModele->getSaisons() as $saisonId) {
            $modele->addSaison($em->getReference("App\Entity\Saison\RtlqSaison", $saisonId()));
        }

        if ($postModele->getPwd() != null) {
            $encoded = $this->encodePassword($modele, $postModele->getPwd());
            $modele->setPassword($encoded);
        }


        return $modele;
    }

    public function modeleToDtoLight($modele, $controller)
    {
        $dto = $controller->newDto();      
        $dto->setId($modele->getId());
        $dto->setEmail($modele->getEmail());
        $dto->setUsername($modele->getUsername());
        // pour des raisons de sécurité ne doit pas être présent
        $dto->setPwd(null);
        $dto->setTelephone($modele->getTelephone());
        $dto->setNom($modele->getNom());
        $dto->setPrenom($modele->getPrenom());
        $dto->setDateNaissance($this->dateToString($modele->getDateNaissance()));
        $dto->setActif($modele->getActif());
        $dto->setPublique($modele->getPublic());
        $dto->setSaisonCourante($modele->isInSaisonCourante());

        $dto->setAdresse($modele->getAdresse());
        $dto->setCodePostal($modele->getCodePostal());
        $dto->setVille($modele->getVille());
        if ("resource" === gettype($modele->getAvatar())) {
            $dto->setAvatar(stream_get_contents($modele->getAvatar()));
        } else {
            $dto->setAvatar($modele->getAvatar());
        }
        $dto->setDateCreation($this->dateToString($modele->getDateCreation()));
        $dto->setDateLastAuth($this->dateToString($modele->getDateLastAuth()));
        $dto->setLicenceNumber($modele->getLicenceNumber());
        $dto->setLicenceEtat($modele->getLicenceEtat());
        $dto->setForumUid($modele->getForumUid());
        $dto->setForumUsername($modele->getForumUsername());
        return $dto;
    }


    public function ofuscated($modeles, $controller)
    {
        $dto_array = array();
        foreach ($modeles as $modele) {
            $dto = $this->modeleToDtoLight($modele, $controller);
            if (! $dto->getPublique()) {
                $dto->setUsername("#####################");
                $dto->setEmail("#####################");
                $dto->setTelephone("#####################");
                $dto->setAdresse("#####################");
                $dto->setCodePostal("#####################");
            }
            array_push($dto_array, $dto);
        }
        return $dto_array;
    }
        

    public function modeleToDto($modele, $controller)
    {
        $dto = $this->modeleToDtoLight($modele, $controller);
        if ($modele->getGroupes() != null) {
            foreach ($modele->getGroupes() as $groupe) {
                $dto->addGroupe($groupe->getId());
            }
        }

        if ($modele->getSaisons() != null) {
            foreach ($modele->getSaisons() as $saison) {
                $dto->addSaison($saison->getId());
            }
        }

        if ($modele->getCotisation() != null) {
            $dto->setCotisationId($modele->getCotisation()->getId());
            $dto->setCotisationName($modele->getCotisation()->getName());
        }
        

        if ($modele->getTresories() != null) {
            $totalEncaisser = 0;
            $totalPrevisionnel = 0;
            $totalEnRetard = 0;
            $now = new \DateTime('NOW');

//            dump("===================");
//            dump(sizeof($modele->getTresories()));

            foreach ($modele->getTresories() as $tresorie) {
                $dto->addTresorie($tresorie->getId());
                if (RtlqTresorieEtat::ENCAISSE === $tresorie->getEtat()->getId() || RtlqTresorieEtat::REGLER === $tresorie->getEtat()->getId()) {
                    $totalEncaisser += $tresorie->getMontant();
                } else if (RtlqTresorieEtat::A_ENCAISSER === $tresorie->getEtat()->getId() || RtlqTresorieEtat::A_RECLAMER === $tresorie->getEtat()->getId()) {
                    $totalPrevisionnel += $tresorie->getMontant();
//                    dump($tresorie);
                    if (RtlqTresorieEtat::A_RECLAMER === $tresorie->getEtat()->getId() && $now > $tresorie->getDateCreation() ) {
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
