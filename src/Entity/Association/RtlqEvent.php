<?php

namespace App\Entity\Association;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Saison\RtlqSaison;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RtlqEvent
 *
 * @ORM\Table(name="rtlq_event")
 * @ORM\Entity
 */
class RtlqEvent extends AbstractRtlqEntity
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="description",  type="string", length=100, nullable=false)
     */
    private $description;

    /**
     *
     * @var string @ORM\Column(name="commentaire", type="string", length=100, nullable=true)
     */
    private $commentaire;

    /**
     *
     * @var string @ORM\Column(name="adresse", type="string", length=100, nullable=false)
     */
    private $adresse;
    /**
     *
     * @var \DateTime @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison\RtlqSaison")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id", nullable=false)
     */
    private $saison;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Association\RtlqAdherent", inversedBy="events")
     * @ORM\JoinTable(name="rtlq_adherents_events",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $adherents;

    /**
     *
     * @var string @ORM\Column(name="nb_accompagnants", type="integer", nullable=false)
     */
    private $nbAccompagnants = 0;

    /**
     *
     * @var string @ORM\Column(name="nb_people", type="integer", nullable=false)
     */
    private $nbPeople = 0;

    public function __construct()
    {
        $this->saison = null;
        $this->adherents = new ArrayCollection();
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
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }
    public function setCommentaire($value)
    {
        $this->commentaire = $value;
        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }
    public function setAdresse($value)
    {
        $this->adresse = $value;
        return $this;
    }

    public function getSaison()
    {
        return $this->saison;
    }
    public function setSaison(RtlqSaison $value)
    {
        $this->saison = $value;
        return $this;
    }
    public function getSaisonNom()
    {
        return $this->saison->getNom();
    }
    public function getSaisonId()
    {
        return $this->saison->getId();
    }

     /**
     * Add adherent
     *
     * @param RtlqAdherent $adherent
     *
     * @return RtlqGroupe
     */
    public function addAdherent(RtlqAdherent $adherent) {
        foreach ($this->adherents as $value) {
            if ($value->getId() == $adherent->getId()) {
                return $this;
            }
        }

        $this->adherents[] = $adherent;
        return $this;
    }

    /**
     * Remove adherent
     *
     * @param RtlqAdherent $adherent
     */
    public function removeAdherent(RtlqAdherent $adherent) {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents
     *
     * @return Collection
     */
    public function getAdherents() {
        return $this->adherents;
    }
    
    public function removeAllAdherents() {
        $this->adherents=[];
    }

    public function getNbAccompagnants()
    {
        return $this->nbAccompagnants;
    }
    public function setNbAccompagnants($value)
    {
        $this->nbAccompagnants = $value;
        return $this;
    }

    public function getNbPeople()
    {
        return $this->nbPeople;
    }
    public function setNbPeople($value)
    {
        $this->nbPeople = $value;
        return $this;
    }
}
