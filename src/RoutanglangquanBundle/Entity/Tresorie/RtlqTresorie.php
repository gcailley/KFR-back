<?php

namespace RoutanglangquanBundle\Entity\Tresorie;

use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;

/**
 * RtlqTresorie
 *
 * @ORM\Table(
 * name="rtlq_tresorie",
 * uniqueConstraints={@ORM\UniqueConstraint(
 * name="TRS_ELT",
 * columns={"description", "date_creation", "montant", "adherent_name"})},
 * indexes={@ORM\Index(name="FK_KFR_TRESORIE", columns={"etat_id"})})
 * @ORM\Entity(repositoryClass="RoutanglangquanBundle\Repository\Tresorie\TresorieRepository")
 */
class RtlqTresorie extends AbstractRtlqEntity {

    public function __construct() {
        $adherent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     *
     * @var integer @ORM\Column(name="id_tresorie", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     *
     * @var string @ORM\Column(name="responsable", type="string", length=255, nullable=false)
     */
    private $responsable;

    /**
     *
     * @var string 
     * @ORM\Column(name="adherent_name", type="string", length=255, nullable=false)
     */
    private $adherentName;

    /**
     *
     * @var \DateTime @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $date_creation;

    /**
     *
     * @var float @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     *
     * @var integer @ORM\Column(name="cheque", type="boolean", nullable=false)
     */
    private $cheque;

    /**
     *
     * @var string @ORM\Column(name="numero_cheque", type="string", length=20, nullable=true)
     */
    private $numeroCheque;

    /**
     *
     * @var RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat 
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     *
     * @var integer 
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Saison\RtlqSaison", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     *
     * @var RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;
    
     /**
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Association\RtlqAdherent", inversedBy="tresories")
     * @ORM\JoinColumn(name="adherent_id", referencedColumnName="id", nullable=true)
     */
    private $adherent;
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @return this
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description        	
     *
     * @return RtlqTresorie
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set responsable
     *
     * @param string $responsable        	
     *
     * @return RtlqTresorie
     */
    public function setResponsable($responsable) {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable() {
        return $this->responsable;
    }

    /**
     * Set adherent
     *
     * @param string $adherent        	
     *
     * @return RtlqTresorie
     */
    public function setAdherent($adherent) {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return string
     */
    public function getAdherent() {
        return $this->adherent;
    }
 /**
     * Get Adherent
     *
     * @return Interger
     */
    public function getAdherentId() {
        return $this->adherent== null ? null : $this->adherent->getId();
    }

    public function getAdherentName() {
        return $this->adherentName;
    }

    public function setAdherentName($adherentName) {
        $this->adherentName = $adherentName;
        return $this;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation        	
     *
     * @return RtlqTresorie
     */
    public function setDateCreation($dateCreation) {
        $this->date_creation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation() {
        return $this->date_creation;
    }

    /**
     * Set montant
     *
     * @param float $montant        	
     *
     * @return RtlqTresorie
     */
    public function setMontant($montant) {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant() {
        return $this->montant;
    }

    /**
     * Set cheque
     *
     * @param integer $cheque        	
     *
     * @return RtlqTresorie
     */
    public function setCheque($cheque) {
        $this->cheque = $cheque;

        return $this;
    }

    /**
     * Get cheque
     *
     * @return integer
     */
    public function getCheque() {
        return $this->cheque;
    }

    /**
     * Set numeroCheque
     *
     * @param string $numeroCheque        	
     *
     * @return RtlqTresorie
     */
    public function setNumeroCheque($numeroCheque) {
        $this->numeroCheque = $numeroCheque;

        return $this;
    }

    /**
     * Get numeroCheque
     *
     * @return string
     */
    public function getNumeroCheque() {
        return $this->numeroCheque;
    }

    /**
     * Set etat
     *
     * @param RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat $etat        	
     *
     * @return RtlqTresorie
     */
    public function setEtat(RtlqTresorieEtat $etat) {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieEtat
     */
    public function getEtat() {
        return $this->etat;
    }

    /**
     * Get etat
     *
     * @return Interger
     */
    public function getEtatId() {
        return $this->etat == null ? null : $this->etat->getId();
    }


    /**
     * Get etat
     *
     * @return Interger
     */
    public function getEtatName() {
        return $this->etat == null ? null : $this->etat->getValue();
    }

    /**
     * Set idSaison
     *
     * @param RoutanglangquanBundle\Entity\Saison\RtlqSaison $saison        	
     *
     * @return RtlqTresorie
     */
    public function setSaison(RtlqSaison $saison) {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return RoutanglangquanBundle\Entity\Saison\RtlqSaison
     */
    public function getSaison() {
        return $this->Saison;
    }

    /**
     * Get saison
     *
     * @return Interger
     */
    public function getSaisonId() {
        return $this->saison == null ? null : $this->saison->getId();
    }
        /**
     * Get saison Nom
     *
     * @return Interger
     */
    public function getSaisonNom() {
        return $this->saison == null ? null : $this->saison->getNom();
    }


    /**
     * Set categorie
     *
     * @param RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie $categorie        	
     *
     * @return RtlqTresorie
     */
    public function setCategorie(RtlqTresorieCategorie $categorie) {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie
     */
    public function getCategorie() {
        return $this->categorie;
    }

    /**
     * Get categorie
     *
     * @return Interger
     */
    public function getCategorieId() {
        return $this->categorie == null ? null : $this->categorie->getId();
    }
    
    /**
     * Get categorie
     *
     * @return Interger
     */
    public function getCategorieNom() {
        return $this->categorie == null ? null : $this->categorie->getValue();
    }

}
