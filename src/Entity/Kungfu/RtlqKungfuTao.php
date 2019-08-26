<?php

namespace App\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\AbstractRtlqEntity;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Association\RtlqAdherent;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_tao",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqKungfuTao extends AbstractRtlqEntity{

    public function __construct() {
        $this->adherents = new ArrayCollection();
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
     * @var string @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }

    public  function getNom() {
        return $this->nom;
    }


    /**
     *
     * @var string @ORM\Column(name="nom_chinois", type="string", length=100, nullable=false)
     */
    private $nomChinois;
    public function setNomChinois($value)
    {
        $this->nomChinois = $value;
        return $this;
    }

    public  function getNomChinois() {
        return $this->nomChinois;
    }

    /**
     *
     * @var string @ORM\Column(name="description", type="string", length=100, nullable=false)
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
     *
     * @var string @ORM\Column(name="origine", type="string", length=100, nullable=false)
     */
    private $origine;
    public function setOrigine($value)
    {
        $this->origine = $value;
        return $this;
    }

    public  function getOrigine() {
        return $this->origine;
    }


    /**
     * @var App\Entity\Kungfu\RtlqKungfuStyle
     * @ORM\ManyToOne(targetEntity="App\Entity\Kungfu\RtlqKungfuStyle", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $style;
    public function setStyle($value)
    {
        $this->style = $value;
        return $this;
    }

    public  function getStyle() {
        return $this->style;
    }
    public  function getStyleId() {
        return ($this->style==null)?null:$this->style->getId();
    }
    public  function getStyleName() {
        return ($this->style==null)?null:$this->style->getValue();
    }
    

    /**
     * @var App\Entity\Kungfu\RtlqKungfuNiveau
     * @ORM\ManyToOne(targetEntity="App\Entity\Kungfu\RtlqKungfuNiveau", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;
    public function setNiveau($value)
    {
        $this->niveau = $value;
        return $this;
    }

    public  function getNiveau() {
        return $this->niveau;
    }
    public  function getNiveauId() {
        return ($this->niveau==null)?null:$this->niveau->getId();
    }
    public  function getNiveauName() {
        return ($this->niveau==null)?null:$this->niveau->getValue();
    }
    /**
     *
     * @var string @ORM\Column(name="arme", type="string", length=100, nullable=true)
     */
    private $arme;
    public function setArme($value)
    {
        $this->arme = $value;
        return $this;
    }

    public  function getArme() {
        return $this->arme;
    }

    /**
     *
     * @var string @ORM\Column(name="arme_url", type="string", length=100, nullable=true)
     */
    private $armeUrl;
    public function setArmeUrl($value)
    {
        $this->armeUrl = $value;
        return $this;
    }

    public  function getArmeUrl() {
        return $this->armeUrl;
    }

    /**
     *
     * @var string @ORM\Column(name="video_url", type="string", length=100, nullable=true)
     */
    private $videoUrl;

    public function setVideoUrl($value)
    {
        $this->videoUrl = $value;
        return $this;
    }

    public  function getVideoUrl() {
        return $this->videoUrl;
    }

    /**
     *
     * @var string @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    protected $actif = false;
    public function getActif() {
        return $this->actif;
    }
    public function setActif($value) {
        $this->actif = $value;
        return $this;
    }

     /**
     *
     * @var string @ORM\Column(name="combine", type="boolean", nullable=false)
     */
    protected $combine = false;
    public function getCombine() {
        return $this->combine;
    }
    public function setCombine($value) {
        $this->combine = $value;
        return $this;
    }

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Association\RtlqAdherent", inversedBy="taos")
     * @ORM\JoinTable(name="rtlq_adherents_taos",
     *      joinColumns={@ORM\JoinColumn(name="tao_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     *      )
     * 
     */
    private $adherents;

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
