<?php

namespace App\Entity\Cotisation;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;
use App\Entity\Saison\RtlqSaison;
use App\Entity\Tresorie\RtlqTresorieCategorie;

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
     * @var string @ORM\Column(name="description", type="string", length=500, nullable=false)
     */
    private $description;

    /**
     * 
     * @var string @ORM\Column(name="type", type="string", length=100, nullable=false)
     */
    private $type;

    
    /**
     * 
     * @var string @ORM\Column(name="nb_cheque", type="integer", nullable=false)
     */
    private $nbCheque;
    
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison\RtlqSaison", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $saison;

    /**
     * @var RtlqTresorieCategorie
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tresorie\RtlqTresorieCategorie", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

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
     * Set type
     *
     * @param \int $type
     *
     * @return RtlqCotisation
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set nbCheque
     *
     * @param \int $nbCheque
     *
     * @return RtlqCotisation
     */
    public function setNbCheque($nbCheque) {
        $this->nbCheque = $nbCheque;

        return $this;
    }

    /**
     * Get nbCheque
     *
     * @return string
     */
    public function getNbCheque() {
        return $this->nbCheque;
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

    public function getRepertitionChequeAsArray() {
        return explode("|", $this->repartitionCheque);
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

    public function getSaisonNom() {
        return $this->saison != null ? $this->saison->getNom() : null;
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

    public function getCategorieNom() {
        return $this->categorie != null ? $this->categorie->getValue() : null;
    }

}
