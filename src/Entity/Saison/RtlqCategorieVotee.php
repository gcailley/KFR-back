<?php

namespace App\Entity\Saison;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;

/**
 * RtlqCategorieVotee.
 *
 * @ORM\Table(name="rtlq_categorie_votee",
 * uniqueConstraints={@ORM\UniqueConstraint(name="categorie_saison", columns={"categorie_id", "saison_id"})},
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity()
 */
class RtlqCategorieVotee extends AbstractRtlqEntity
{
    public function __construct()
    {
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id = null;

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
     * @var number
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * Get id.
     *
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set id.
     *
     * @return $this
     */
    public function setMontant($value)
    {
        $this->montant = $value;
        return $this;
    }



    /**
     * @var App\Entity\Tresorie\RtlqTresorieCategorie
     * @ORM\ManyToOne(targetEntity="App\Entity\Tresorie\RtlqTresorieCategorie", cascade={"persist"})
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=true)
     */
    private $categorie;
    public function setCategorie($value)
    {
        $this->categorie = $value;
        return $this;
    }
    public  function getCategorie() {
        return $this->categorie;
    }
    public  function getCategorieId() {
        return ($this->categorie==null)?null:$this->categorie->getId();
    }
    public  function getCategorieName() {
        return ($this->categorie==null)?null:$this->categorie->getValue();
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison\RtlqSaison", inversedBy="categorieVotees")
     * @ORM\JoinColumn(name="saison_id", referencedColumnName="id", nullable=true)
     */
    private $saison;
    public function setSaison($value)
    {
        $this->saison = $value;
        return $this;
    }

    public  function getSaison() {
        return $this->saison;
    }
    public  function getSaisonId() {
        return ($this->saison==null)?null:$this->saison->getId();
    }
    public  function getSaisonName() {
        return ($this->saison==null)?null:$this->saison->getNom();
    }

}
