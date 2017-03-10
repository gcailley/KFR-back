<?php

namespace RoutanglangquanBundle\Entity\Cotisation;

use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_cotisation",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqCotisation extends AbstractRtlqEntity {

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     *
     * @var string @ORM\Column(name="cotisation", type="integer", nullable=false)
     */
    private $cotisation;

    /**
     *
     * @var string @ORM\Column(name="repartition_cheque", type="string", length=15, nullable=false)
     */
    private $repartitionCheque;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     *
     * @var integer 
     * 
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Saison\RtlqSaison", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     * @var RtlqTresorieCategorie
     *
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Tresorie\RtlqTresorieCategorie", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function isNotIntowithTheSameSeasonInto($collections) {
        foreach ($collections as $key => $value) {
            if ($this->isEquals($value) || $this->getSaisonId() == $value->getSaisonId()) {
                return false;
            }
        }
        return true;
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
     * Set description
     *
     * @param string $description
     *
     * @return RtlqCotisation
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
     * Set cotisation
     *
     * @param \int $cotisation
     *
     * @return RtlqCotisation
     */
    public function setCotisation($cotisation) {
        $this->cotisation = $cotisation;

        return $this;
    }

    /**
     * Get cotisation
     *
     * @return \int
     */
    public function getCotisation() {
        return $this->cotisation;
    }

    /**
     * Set repartitionCheque
     *
     * @param string $repartitionCheque
     *
     * @return RtlqCotisation
     */
    public function setRepartitionCheque($repartitionCheque) {
        $this->repartitionCheque = $repartitionCheque;

        return $this;
    }

    /**
     * Get repartitionCheque
     *
     * @return string
     */
    public function getRepartitionCheque() {
        return $this->repartitionCheque;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return RtlqCotisation
     */
    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive() {
        return $this->active;
    }

    /**
     * Set saison
     *
     * @param RtlqSaison $saison
     *
     * @return RtlqCotisation
     */
    public function setSaison(RtlqSaison $saison) {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return RtlqSaison
     */
    public function getSaison() {
        return $this->saison;
    }

    public function getSaisonId() {
        return $this->saison != null ? $this->saison->getId() : null;
    }

    /**
     * Set categorie
     *
     * @param RtlqTresorieCategorie $categorie
     *
     * @return RtlqCotisation
     */
    public function setCategorie(RtlqTresorieCategorie $categorie) {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return RtlqTresorieCategorie
     */
    public function getCategorie() {
        return $this->categorie;
    }

    public function getCategorieId() {
        return $this->categorie != null ? $this->categorie->getId() : null;
    }

}
