<?php

namespace App\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\AbstractRtlqEntity;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_tao",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\Kungfu\TaoRepository")
 */
class RtlqKungfuTao extends AbstractRtlqEntity
{

    public function __construct()
    {
        $this->taos_learnt = new ArrayCollection();
        $this->referents = new ArrayCollection();
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

    public  function getId()
    {
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

    public  function getNom()
    {
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

    public  function getNomChinois()
    {
        return $this->nomChinois;
    }

    /**
     *
     * @var string @ORM\Column(name="traduction", type="string", length=100, nullable=false)
     */
    private $traduction;
    public function setTraduction($value)
    {
        $this->traduction = $value;
        return $this;
    }

    public  function getTraduction()
    {
        return $this->traduction;
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

    public  function getOrigine()
    {
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

    public  function getStyle()
    {
        return $this->style;
    }
    public  function getStyleId()
    {
        return ($this->style == null) ? null : $this->style->getId();
    }
    public  function getStyleName()
    {
        return ($this->style == null) ? null : $this->style->getValue();
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

    public  function getNiveau()
    {
        return $this->niveau;
    }
    public  function getNiveauId()
    {
        return ($this->niveau == null) ? null : $this->niveau->getId();
    }
    public  function getNiveauName()
    {
        return ($this->niveau == null) ? null : $this->niveau->getValue();
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

    public  function getArme()
    {
        return $this->arme;
    }

    /**
     *
     * @var string @ORM\Column(name="pinyin", type="string", length=100, nullable=true)
     */
    private $pinyin;
    public function setPinyin($value)
    {
        $this->pinyin = $value;
        return $this;
    }

    public  function getPinYin()
    {
        return $this->pinyin;
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

    public  function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     *
     * @var string @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    protected $actif = false;
    public function getActif()
    {
        return $this->actif;
    }
    public function setActif($value)
    {
        $this->actif = $value;
        return $this;
    }

    /**
     *
     * @var string @ORM\Column(name="combine", type="boolean", nullable=false)
     */
    protected $combine = false;
    public function getCombine()
    {
        return $this->combine;
    }
    public function setCombine($value)
    {
        $this->combine = $value;
        return $this;
    }

    public function isInto($collections)
    {
        foreach ($collections as $key => $value) {
            if ($this->isEquals($value->getTao())) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @var string @ORM\Column(name="nb_moves", type="integer", nullable=true)
     */
    protected $nb_moves = false;
    public function getNbMoves()
    {
        return $this->nb_moves;
    }
    public function setNbMoves($value)
    {
        $this->nb_moves = $value;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\KungFu\RtlqKungfuAdherentTao", mappedBy="tao", cascade={"persist"})
     */
    private $taos_learnt;
    public function getTaosLearnt()
    {
        return $this->taos_learnt;
    }
    public function setTaosLearnt($taos_learnt)
    {
        $this->taos_learnt = $taos_learnt;
        return $this;
    }


    /**
     *
     * @var string @ORM\Column(name="reference_drive_id", type="string", nullable=true)
     */
    protected $reference_drive_id = false;
    public function getReferenceDriveId()
    {
        return $this->reference_drive_id;
    }
    public function setReferenceDriveId($value)
    {
        $this->reference_drive_id = $value;
        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Association\RtlqAdherent", inversedBy="taos_referent", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="rtlq_referents_taos",
     *      joinColumns={@ORM\JoinColumn(name="tao_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="adherent_id", referencedColumnName="id")}
     *      )
     */
    private $referents;
    /**
     * Add referent
     *
     * @param RtlqAdherent $referent
     */
    public function addReferent(RtlqAdherent $referent)
    {
        foreach ($this->referents as $value) {
            if ($value->getId() == $referent->getId()) {
                return $this;
            }
        }

        $this->referents[] = $referent;
        return $this;
    }

    /**
     * Remove referent
     *
     * @param RtlqAdherent $referent
     */
    public function removeReferents(RtlqAdherent $referent)
    {
        $this->referents->removeElement($referent);
    }

    /**
     * Get referents
     *
     * @return Collection
     */
    public function getReferents()
    {
        return $this->referents;
    }

    public function removeAllReferents()
    {
        $this->referents = [];
    }

}
