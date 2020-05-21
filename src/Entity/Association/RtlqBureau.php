<?php

namespace App\Entity\Association;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Saison\RtlqSaison;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RtlqBureau.
 *
 * @ORM\Table(name="rtlq_bureau")
 * @ORM\Entity
 */
class RtlqBureau extends AbstractRtlqEntity
{
    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Get id.
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

    /**
     * @var \DateTime @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }


    /**
     * @var \DateTime @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }
    public function getDateFin()
    {
        return $this->dateFin;
    }



    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Saison\RtlqSaison", inversedBy="bureaux")
     * @ORM\JoinTable(name="rtlq_bureaux_saisons",
     *      joinColumns={@ORM\JoinColumn(name="bureau_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="saison_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $saisons;

    /**
     * Add saison
     * @param RtlqSaison $saison
     */
    public function addSaison(RtlqSaison $saison){
        foreach ($this->saisons as $value) {
            if ($value->getId() == $saison->getId()) {
                return $this;
            }
        }
        $this->saisons[] = $saison;
        return $this;
    }

    /**
     * Remove saison
     *
     * @param RtlqSaison $saison
     */
    public function removeSaison(RtlqSaison $saison){
        $this->saisons->removeElement($saison);
    }

    /**
     * Get saisons
     *
     * @return Collection
     */
    public function getSaisons(){
        return $this->saisons;
    }

    public function removeAllSaisons(){
        $this->saisons = [];
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqAdherent")
     * @ORM\JoinColumn(name="president_id", referencedColumnName="id" , nullable=false)
     */
    private $president;
    public function getPresident()
    {
        return $this->president;
    }

    public function setPresident(RtlqAdherent $value)
    {
        $this->president = $value;

        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqAdherent")
     * @ORM\JoinColumn(name="secretaire_id", referencedColumnName="id" , nullable=false)
     */
    private $secretaire;
    public function getSecretaire()
    {
        return $this->secretaire;
    }

    public function setSecretaire(RtlqAdherent $value)
    {
        $this->secretaire = $value;
        return $this;
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqAdherent")
     * @ORM\JoinColumn(name="tresorier_id", referencedColumnName="id" , nullable=false)
     */
    private $tresorier;
    public function getTresorier()
    {
        return $this->tresorier;
    }

    public function setTresorier(RtlqAdherent $value)
    {
        $this->tresorier = $value;

        return $this;
    }



    public function __construct()
    {
        parent::__construct();
        $this->saisons = new ArrayCollection();
        $this->president = null;
        $this->tresorier = null;
        $this->secretaire = null;
    }
}
