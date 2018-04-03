<?php

namespace RoutanglangquanBundle\Entity\Association;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqGroupe
 *
 * @ORM\Table(name="rtlq_groupe", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="nom", columns={"nom"})}, 
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqGroupe extends AbstractRtlqEntity {

    /**
     * @var integer
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
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20, nullable=false)
     */
    private $role;
    
    /**
     * @ORM\ManyToMany(targetEntity="RoutanglangquanBundle\Entity\Association\RtlqAdherent", inversedBy="groupes")
     * @ORM\JoinTable(name="rtlq_adherents_groupes",
     *      joinColumns={@ORM\JoinColumn(name="groupe_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $adherents;

    public function __construct() {
        $this->adherents = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return RtlqGroupe
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
     * Set nom
     *
     * @param string $role
     *
     * @return RtlqGroupe
     */
    public function setRole($value) {
        $this->role = $value;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole() {
        return $this->role;
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

}
