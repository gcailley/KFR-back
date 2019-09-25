<?php

namespace App\Entity\Association;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorieCategorie;

/**
 * RtlqBenevolat.
 *
 * @ORM\Table(name="rtlq_benevolat")
 * @ORM\Entity
 */
class RtlqBenevolat extends AbstractRtlqEntity
{
    /**
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="description",  type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var string @ORM\Column(name="heure", type="integer", nullable=false)
     */
    private $heure = 0;

    /**
     * @var string @ORM\Column(name="minute", type="integer", nullable=false)
     */
    private $minute = 0;

    /**
     * @var \DateTime @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqAdherent")
     * @ORM\JoinColumn(name="adherent_id", referencedColumnName="id" , nullable=false)
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison\RtlqSaison")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id", nullable=false)
     */
    private $saison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tresorie\RtlqTresorieCategorie")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=false)
     */
    private $categorie;

    public function __construct()
    {
        parent::__construct();
        $this->saison = null;
        $this->adherent = null;
        $this->categorie = null;
    }

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

    public function getHeure()
    {
        return $this->heure;
    }

    public function setHeure($value)
    {
        $this->heure = $value;

        return $this;
    }

    public function getMinute()
    {
        return $this->minute;
    }

    public function setMinute($value)
    {
        $this->minute = $value;

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

    public function getAdherent()
    {
        return $this->adherent;
    }

    public function setAdherent(RtlqAdherent $value)
    {
        $this->adherent = $value;

        return $this;
    }

    public function getAdherentPrenomNom()
    {
        return $this->adherent->getPrenomNom();
    }

    public function getAdherentId()
    {
        return $this->adherent->getId();
    }


    
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function setCategorie(RtlqTresorieCategorie $value)
    {
        $this->categorie = $value;

        return $this;
    }

    public function getCategorieNom()
    {
        return $this->categorie->getValue();
    }

    public function getCategorieId()
    {
        return $this->categorie->getId();
    }
}
