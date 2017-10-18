<?php

namespace RoutanglangquanBundle\Entity\Association;

use Doctrine\ORM\Mapping as ORM;

/**
 * RtlqAdherent
 *
 * @ORM\Table(name="rtlq_adherent",
 * uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})},
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqAdherent {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     *
     * @var string //TODO encrypted
     *      @ORM\Column(name="pwd", type="string", length=100, nullable=false)
     */
    private $pwd;

    /**
     *
     * @var string @ORM\Column(name="telephone", type="string", length=10, nullable=false)
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
     * @var string @ORM\Column(name="avatar", type="string", length=100, nullable=false)
     */
    private $avatar;

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
     * @ORM\ManyToMany(targetEntity="RoutanglangquanBundle\Entity\Association\RtlqGroupe", inversedBy="adherents" )
     * @ORM\JoinTable(name="adherents_groupes",
     *      joinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="groupe_id", referencedColumnName="id")}
     *      )
     */
    private $groupes;

    /**
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation")
     * @ORM\JoinColumn(name="cotisation_id", referencedColumnName="id")
     */
    private $cotisation;

    /**
     * @ORM\OneToMany(targetEntity="RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie", mappedBy="adherent")
     */
    private $tresories;

    public function __construct() {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cotisation = null;
        $this->tresories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // TODO licence as object
    // TODO adherentForum as object

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RtlqAdherent
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set pwd
     *
     * @param string $pwd
     *
     * @return RtlqAdherent
     */
    public function setPwd($pwd) {
        $this->pwd = $pwd;

        return $this;
    }

    /**
     * Get pwd
     *
     * @return string
     */
    public function getPwd() {
        return $this->pwd;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return RtlqAdherent
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return RtlqAdherent
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return RtlqAdherent
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return RtlqAdherent
     */
    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return RtlqAdherent
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Set public
     *
     * @param boolean $public
     *
     * @return RtlqAdherent
     */
    public function setPublic($public) {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic() {
        return $this->public;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return RtlqAdherent
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return RtlqAdherent
     */
    public function setAvatar($avatar) {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return RtlqAdherent
     */
    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal() {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return RtlqAdherent
     */
    public function setVille($ville) {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille() {
        return $this->ville;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return RtlqAdherent
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

    /**
     * Add groupe
     *
     * @param \RoutanglangquanBundle\Entity\Association\RtlqGroupe $groupe
     *
     * @return RtlqAdherent
     */
    public function addGroupe(\RoutanglangquanBundle\Entity\Association\RtlqGroupe $groupe) {
        $this->groupes[] = $groupe;

        return $this;
    }

    /**
     * Remove groupe
     *
     * @param \RoutanglangquanBundle\Entity\Association\RtlqGroupe $groupe
     */
    public function removeGroupe(\RoutanglangquanBundle\Entity\Association\RtlqGroupe $groupe) {
        $this->groupes->removeElement($groupe);
    }
    /**
     * Remove All groupes
     *
     */
    public function removeAllGroupes() {
        $this->groupes= [];
    }
    /**
     * Get groupes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroupes() {
        return $this->groupes;
    }
    
    public function getCotisation() {
        return $this->cotisation;
    }

    public function setCotisation($cotisation) {
        $this->cotisation = $cotisation;
        return $this;
    }
    public function removeCotisation() {
        $this->cotisation = null;
    }
    
    public function getDateLastAuth() {
        return $this->dateLastAuth;
    }

    public function setDateLastAuth(\DateTime $dateLastAuth) {
        $this->dateLastAuth = $dateLastAuth;
        return $this;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }


    
    /**
     * has tresories ?
     *
     * @return boolean
     */
     public function hasTresories() {
        return sizeof($this->tresories) > 0;
    }

    /**
     * Add tresorie
     *
     * @param \RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie $tresories
     *
     * @return RtlqTresorie
     */
    public function addTresorie(\RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie $tresorie) {
        $this->tresories[] = $tresorie;

        return $this;
    }

    /**
     * Remove tresorie
     *
     * @param \RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie $tresorie
     */
    public function removeTresorie(\RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie $tresorie) {
        $this->tresories->removeElement($tresorie);
        $tresorie->setAdherent(null);
    }
    
    /**
     * Remove All tresorie
     *
     * @param \RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie $tresorie
     */
    public function removeAllTresories() {
        foreach ($this->tresories as $tresorie) {
            $this->removeTresorie($tresorie);
        }
    }

    public function getTresories() {
        return $this->tresories;
    }

    public function getLicenceNumber() {
        return $this->licenceNumber;
    }

    public function getLicenceEtat() {
        return $this->licenceEtat;
    }

    public function setLicenceNumber($licenceNumber) {
        $this->licenceNumber = $licenceNumber;
        return $this;
    }

    public function setLicenceEtat($licenceEtat) {
        $this->licenceEtat = $licenceEtat;
        return $this;
    }
}
