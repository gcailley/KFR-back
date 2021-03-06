<?php

namespace App\Entity\Association;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Cotisation\RtlqCotisation;
use App\Entity\Kungfu\RtlqKungfuAdherentTao;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorie;


/**
 * RtlqAdherent
 *
 * @ORM\Table(name="rtlq_adherent",
 * uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})},
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\Association\AdherentRepository")
 */
class RtlqAdherent extends AbstractRtlqEntity implements UserInterface
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
     */
    private $username;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     *
     * @var string
     * @ORM\Column(name="password", type="string", length=64, nullable=false)
     */
    private $password;

    /**
     *
     * @var string @ORM\Column(name="telephone", type="string", length=20, nullable=false)
     */
    private $telephone;

    /**
     *
     * @var string @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     *
     * @var string @ORM\Column(name="prenom", type="string", length=100, nullable=false)
     */
    private $prenom;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     *
     * @var boolean @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     *
     * @var boolean @ORM\Column(name="public", type="boolean", nullable=false)
     */
    private $public;

    /**
     *
     * @var string @ORM\Column(name="adresse", type="string", length=100, nullable=false)
     */
    private $adresse;

    /**
     *
     * @var string @ORM\Column(name="avatar", type="blob", nullable=true)
     */
    private $avatar;

    /**
     *
     * @var string @ORM\Column(name="avatar_name", type="string", nullable=true)
     */
    private $avatar_name;

    /**
     *
     * @var string @ORM\Column(name="codePostal", type="string", length=5, nullable=false)
     */
    private $codePostal;

    /**
     *
     * @var string @ORM\Column(name="ville", type="string", length=100, nullable=false)
     */
    private $ville;

    /**
     *
     * @var string @ORM\Column(name="forum_uid", type="string", length=100, nullable=true)
     */
    private $forumUid;

    /**
     *
     * @var string @ORM\Column(name="forum_username", type="string", length=100, nullable=true)
     */
    private $forumUsername;


    /**
     *
     * @var \DateTime @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_last_auth", type="date", nullable=true)
     */
    private $dateLastAuth;

    /**
     *
     * @var string @ORM\Column(name="licence_number", type="string", length=100, nullable=true)
     */
    private $licenceNumber;

    /**
     *
     * @var string @ORM\Column(name="licence_etat", type="string", length=100, nullable=true)
     */
    private $licenceEtat;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="App\Entity\Association\RtlqGroupe", mappedBy="adherents")
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Cotisation\RtlqCotisation", mappedBy="adherents")
     */
    private $cotisations;

    /**
     * Add groupe
     *
     * @param RtlqCotisation $cotisation
     *
     * @return RtlqAdherent
     */
    public function addCotisation(RtlqCotisation $cotisation)
    {
        //before adding the cotisation we should check if a cotisation is already attach to a current season.
        // if so we can switch the cotisations
        $cotisationSaisonCourante = $this->getCotisationSaisonCourante();
        if (null != $cotisationSaisonCourante) {
            $cotisationSaisonCourante->removeAdherent($this);
            $this->cotisations->removeElement($cotisationSaisonCourante);
        }

        $cotisation->addAdherent($this);
        $this->cotisations[] = $cotisation;

        return $this;
    }

    /**
     * Remove cotisation
     *
     * @param RtlqCotisation $cotisation
     */
    public function removeCotisation(RtlqCotisation $cotisation)
    {
        $this->cotisations->removeElement($cotisation);
    }
    /**
     * Remove All cotisations
     *
     */
    public function removeAllCotisations()
    {
        $this->cotisations = [];
    }
    /**
     * Get cotisations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCotisations()
    {
        return $this->cotisations;
    }

    public function getCotisationSaisonCourante()
    {
        foreach ($this->cotisations as $cotisation) {
            if ($cotisation->isSaisonCourante()) {
                return $cotisation;
            }
        };
    }


    public function removeCotisationSaisonCourante()
    {
        $cotisationsToRemove = [];
        foreach ($this->cotisations as $cotisation) {
            if ($cotisation->isSaisonCourante()) {
                $cotisationsToRemove[] = $cotisation;
            }
        };

        foreach ($cotisationsToRemove as $c) {
            $this->removeCotisation($c);
            $c->removeAdherent($this);
        }
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tresorie\RtlqTresorie", mappedBy="adherent", cascade={"persist"})
     */
    private $tresories;

    /**
     *
     * @var string @ORM\Column(name="token_pwd", type="string", length=100, nullable=true)
     */
    private $tokenPwd;


    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cotisations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tresories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->taos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function isInSaisonCourante()
    {
        foreach ($this->cotisations as $cotisation) {
            if ($cotisation->isSaisonCourante()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RtlqAdherent
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return RtlqAdherent
     */
    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return RtlqAdherent
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return RtlqAdherent
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return RtlqAdherent
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getPrenomNom()
    {
        return sprintf("%s %s", $this->prenom,  $this->nom);
    }


    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return RtlqAdherent
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return RtlqAdherent
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return RtlqAdherent
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return RtlqAdherent
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set avatar
     *
     * @param blob $avatar
     *
     * @return RtlqAdherent
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return blob
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatar_name
     *
     * @param strign $avatar_name
     *
     * @return RtlqAdherent
     */
    public function setAvatarName($avatar_name)
    {
        $this->avatar_name = $avatar_name;

        return $this;
    }

    /**
     * Get avatar_name
     *
     * @return string
     */
    public function getAvatarName()
    {
        return $this->avatar_name;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return RtlqAdherent
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return RtlqAdherent
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return RtlqAdherent
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }


    /**
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Kungfu\RtlqKungfuAdherentTao", mappedBy="adherent", cascade={"persist"})
     */
    private $taos;

    /**
     * Add groupe
     *
     * @param \App\Entity\Kungfu\RtlqKungfuAdherentTao $tao
     *
     * @return RtlqKungfuAdherentTao
     */
    public function addTao(RtlqKungfuAdherentTao $tao)
    {
        $tao->setAdherent($this);
        $this->taos[] = $tao;

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \App\Entity\KungFu\RtlqKungfuAdherentTao $tao
     */
    public function removeTao(RtlqKungfuAdherentTao   $tao)
    {
        $tao->removeAdherent();
        $this->taos->removeElement($tao);
    }

    /**
     * Remove All taos
     *
     */
    public function removeAllTaos()
    {
        $this->taos = [];
    }
    /**
     * Get taos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaos()
    {
        return $this->taos;
    }



    /**
     * Add groupe
     *
     * @param \App\Entity\Association\RtlqGroupe $groupe
     *
     * @return RtlqAdherent
     */
    public function addGroupe(\App\Entity\Association\RtlqGroupe $groupe)
    {
        $groupe->addAdherent($this);
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \App\Entity\Association\RtlqGroupe $groupe
     */
    public function removeGroupe(\App\Entity\Association\RtlqGroupe $groupe)
    {
        $this->groupes->removeElement($groupe);
    }
    /**
     * Remove All groupes
     *
     */
    public function removeAllGroupes()
    {
        $this->groupes = [];
    }
    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes()
    {
        return $this->groupes;
    }



    public function setForumUid($value)
    {
        $this->forumUid = $value;
        return $this;
    }
    public function getForumUid()
    {
        return $this->forumUid;
    }

    public function setForumUsername($value)
    {
        $this->forumUsername = $value;
        return $this;
    }
    public function getForumUsername()
    {
        return $this->forumUsername;
    }

    public function getDateLastAuth()
    {
        return $this->dateLastAuth;
    }

    public function setDateLastAuth(\DateTime $dateLastAuth)
    {
        $this->dateLastAuth = $dateLastAuth;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



    /**
     * has tresories ?
     *
     * @return boolean
     */
    public function hasTresories()
    {
        return sizeof($this->tresories) > 0;
    }

    /**
     * Add tresorie
     *
     * @param \App\Entity\Tresorie\RtlqTresorie $tresories
     *
     * @return RtlqTresorie
     */
    public function addTresorie(RtlqTresorie $tresorie)
    {
        $this->tresories[] = $tresorie;

        return $this;
    }

    /**
     * Remove tresorie
     *
     * @param \App\Entity\Tresorie\RtlqTresorie $tresorie
     */
    public function removeTresorie(RtlqTresorie $tresorie)
    {
        $this->tresories->removeElement($tresorie);
        $tresorie->setAdherent(null);
    }

    /**
     * Remove All tresorie
     *
     * @param \App\Entity\Tresorie\RtlqTresorie $tresorie
     */
    public function removeAllTresories()
    {
        foreach ($this->tresories as $tresorie) {
            $this->removeTresorie($tresorie);
        }
    }

    public function getTresories()
    {
        return $this->tresories;
    }



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kungfu\RtlqKungfuTao", mappedBy="referents")
     */
    private $taos_referent;

    /**
     * Add groupe
     *
     * @param RtlqKungfuTao $tao_referent
     *
     * @return RtlqAdherent
     */
    public function addTaoReferent(RtlqKungfuTao $tao_referent)
    {
        $tao_referent->addReferent($this);
        $this->taos_referent[] = $tao_referent;

        return $this;
    }

    /**
     * Remove taoReference
     *
     * @param RtlqKungfuTao $tao_referent
     */
    public function removeTaoReference(RtlqKungfuTao $tao_referent)
    {
        $this->taos_referent->removeElement($tao_referent);
    }
    /**
     * Remove All taosReference
     *
     */
    public function removeAllTaosReference()
    {
        $this->taos_referent = [];
    }
    /**
     * Get taos_referent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaosReference()
    {
        return $this->taos_referent;
    }


    public function getLicenceNumber()
    {
        return $this->licenceNumber;
    }

    public function getLicenceEtat()
    {
        return $this->licenceEtat;
    }

    public function setLicenceNumber($licenceNumber)
    {
        $this->licenceNumber = $licenceNumber;
        return $this;
    }

    public function setLicenceEtat($licenceEtat)
    {
        $this->licenceEtat = $licenceEtat;
        return $this;
    }

    public function setUsername($value)
    {
        $this->username = $value;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setTokenPwd($value)
    {
        $this->tokenPwd = $value;
        return $this;
    }
    public function getTokenPwd()
    {
        return $this->tokenPwd;
    }


    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        $roles = array('ANONYMOUS');
        foreach ($this->groupes as $groupe) {
            $roles[] = $groupe->getRole();
        };
        return $roles;
    }



    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->actif,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->actif,
        ) = unserialize($serialized);
    }
}
