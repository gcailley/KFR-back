<?php

namespace RoutanglangquanBundle\Entity\Association;

use Doctrine\ORM\Mapping as ORM;

/**
 * RtlqGroupe
 *
 * @ORM\Table(name="rtlq_groupe", 
 * uniqueConstraints={@ORM\UniqueConstraint(name="nom", columns={"nom"})}, 
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqGroupe
{
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
     * @ORM\ManyToMany(targetEntity="RoutanglangquanBundle\Entity\Association\RtlqAdherent", inversedBy="groupes")
     * @ORM\JoinTable(name="adherents_groups")
     */
    private $adherents;

    
    public function __construct() {
    	$this->$adherents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return RtlqGroupe
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
     * Add adherent
     *
     * @param \RoutanglangquanBundle\Entity\Association\RtlqAdherent $adherent
     *
     * @return RtlqGroupe
     */
    public function addAdherent(\RoutanglangquanBundle\Entity\Association\RtlqAdherent $adherent)
    {
        $this->adherents[] = $adherent;

        return $this;
    }

    /**
     * Remove adherent
     *
     * @param \RoutanglangquanBundle\Entity\Association\RtlqAdherent $adherent
     */
    public function removeAdherent(\RoutanglangquanBundle\Entity\Association\RtlqAdherent $adherent)
    {
        $this->adherents->removeElement($adherent);
    }

    /**
     * Get adherents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdherents()
    {
        return $this->adherents;
    }
}
