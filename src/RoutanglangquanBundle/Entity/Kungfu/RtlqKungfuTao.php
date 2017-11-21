<?php

namespace RoutanglangquanBundle\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;

use RoutanglangquanBundle\Entity\AbstractRtlqEntity;
use RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuStyle;
use RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuNiveau;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_tao",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class RtlqKungfuTao extends AbstractRtlqEntity{


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
     * @var RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuStyle
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuStyle", cascade={"persist"})
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
     * @var RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuNiveau
     * @ORM\ManyToOne(targetEntity="RoutanglangquanBundle\Entity\Kungfu\RtlqKungfuNiveau", cascade={"persist"})
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
     * @var string @ORM\Column(name="arme_url", type="string", length=100, nullable=false)
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
     * @var string @ORM\Column(name="video_url", type="string", length=100, nullable=false)
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
     * @var string @ORM\Column(name="actif", type="string", length=100, nullable=false)
     */
    protected $actif;
    public function getActif() {
        return $this->actif;
    }
    public function setActif($value) {
        $this->actif = $value;
        return $this;
    }
}
