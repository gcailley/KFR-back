<?php

namespace App\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\AbstractRtlqEntity;
use App\Entity\Saison\RtlqSaison;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_cours",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqKungfuCours extends AbstractRtlqEntity{

    public function __construct() {
        
    }

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    public  function getId() {
        return $this->id;
    }


    /**
     *
     * @var string @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    public  function getDescription() {
        return $this->description;
    }




    /**
     * @var App\Entity\Saison\RtlqSaison
     * @ORM\ManyToOne(targetEntity="App\Entity\Saison\RtlqSaison", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
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
    
    /**
     *
     * @var string @ORM\Column(name="thematique_tao", type="boolean", nullable=false)
     */
    protected $thematique_tao = false;
    public function getThematiqueTao() {
        return $this->thematique_tao;
    }
    public function setThematiqueTao($value) {
        $this->thematique_tao = $value;
        return $this;
    }

    /**
     *
     * @var string @ORM\Column(name="thematique_application", type="boolean", nullable=false)
     */
    protected $thematique_application = false;
    public function getThematiqueApplication() {
        return $this->thematique_application;
    }
    public function setThematiqueApplication($value) {
        $this->thematique_application = $value;
        return $this;
    }
        /**
     *
     * @var string @ORM\Column(name="thematique_combat", type="boolean", nullable=false)
     */
    protected $thematique_combat = false;
    public function getThematiqueCombat() {
        return $this->thematique_combat;
    }
    public function setThematiqueCombat($value) {
        $this->thematique_combat = $value;
        return $this;
    }


    
    /**
     *
     * @var \DateTime @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;
       /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RtlqAdherent
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

}
