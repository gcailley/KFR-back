<?php

namespace App\Entity\Saison;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Association\RtlqAdherent;

/**
 * RtlqSaison.
 *
 * @ORM\Table(name="rtlq_saison",
 * uniqueConstraints={@ORM\UniqueConstraint(name="nom", columns={"nom"})},
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity()
 */
class RtlqSaison extends AbstractRtlqEntity
{
    public function __construct()
    {
        $this->adherents = new ArrayCollection();
        $this->cotisations = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Association\RtlqAdherent", inversedBy="saisons", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="rtlq_adherents_saisons",
     *      joinColumns={@ORM\JoinColumn(name="saison_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     *      )
     */
    private $adherents;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Cotisation\RtlqCotisation", mappedBy="saison", cascade={"persist"})
     */
    private $cotisations;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return RtlqSaison
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dateDebut.
     *
     * @param \DateTime $dateDebut
     *
     * @return RtlqSaison
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut.
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin.
     *
     * @param \DateTime $dateFin
     *
     * @return RtlqSaison
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin.
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set active.
     *
     * @param bool $active
     *
     * @return RtlqSaison
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active.
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add adherent.
     *
     * @param RtlqAdherent $adherent
     *
     * @return RtlqGroupe
     */
    public function addAdherent(RtlqAdherent $adherent)
    {
        foreach ($this->adherents as $value) {
            if ($value->getId() == $adherent->getId()) {
                return $this;
            }
        }

        $this->adherents[] = $adherent;

        return $this;
    }

    /**
     * Remove adherent.
     *
     * @param RtlqAdherent $adherent
     */
    public function removeAdherent(RtlqAdherent $adherent)
    {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents.
     *
     * @return Collection
     */
    public function getAdherents()
    {
        return $this->adherents;
    }

    public function removeAllAdherents()
    {
        $this->adherents = [];
    }

    public function getCotisations()
    {
        return $this->cotisations;
    }

    public function setCotisations($value)
    {
        $this->cotisations = $value;

        return $this;
    }
}
