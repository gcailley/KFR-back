<?php

namespace App\Entity\Kungfu;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\AbstractRtlqEntity;
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Entity\Association\RtlqAdherent;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * RtlqCotisation
 *
 * @ORM\Table(name="rtlq_adherents_taos",
 * indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\Kungfu\AdherentTaoRepository")
 */
class RtlqKungfuAdherentTao extends AbstractRtlqEntity
{

    public function __construct()
    { }

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
     * @var string @ORM\Column(name="nb_revision", type="integer", nullable=false)
     */
    private $nbRevision = 0;
    public function setNbRevision($value)
    {
        $this->nbRevision = $value;
        return $this;
    }

    public  function getNbRevision()
    {
        return $this->nbRevision;
    }

    /**
     *
     * @var string @ORM\Column(name="niveau", type="integer", nullable=false)
     */
    private $niveau = 0;
    public function setNiveau($value)
    {
        $this->niveau = $value;
        return $this;
    }

    public  function getNiveau()
    {
        return $this->niveau;
    }


    /**
     *
     * @var string @ORM\Column(name="annee_apprentissage", type="string", nullable=true)
     */
    private $anneeApprentissage = null;
    public function setAnneeApprentissage($value)
    {
        $this->anneeApprentissage = $value;
        return $this;
    }

    public  function getAnneeApprentissage()
    {
        return $this->anneeApprentissage;
    }


    /**
     *
     * @var string @ORM\Column(name="drive_id", type="string", nullable=true)
     */
    private $drive_id = 0;
    public function setDriveId($value)
    {
        $this->drive_id = $value;
        return $this;
    }

    public  function getDriveId()
    {
        return $this->drive_id;
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Association\RtlqAdherent", inversedBy="taos")
     * @ORM\JoinColumn(name="adherent_id", referencedColumnName="id", nullable=true)
     */
    private $adherent;

    /**
     * Add adherent
     *
     * @param RtlqAdherent $adherent
     *
     * @return RtlqAdherent
     */
    public function setAdherent(RtlqAdherent $adherent)
    {
        $this->adherent = $adherent;
        return $this;
    }
    /**
     * Get adherents
     *
     * @return Collection
     */
    public function getAdherent()
    {
        return $this->adherent;
    }

    public function getAdherentId()
    {
        return $this->adherent->getId();
    }

    public function removeAdherent()
    {
        $this->adherent = null;
    }



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Kungfu\RtlqKungfuTao")
     * @ORM\JoinColumn(name="tao_id", referencedColumnName="id", nullable=false)
     */
    private $tao;

    /**
     * Add adherent
     *
     * @param RtlqKungfuTao $tao
     *
     * @return RtlqKungfuTao
     */
    public function setTao(RtlqKungfuTao $tao)
    {
        $this->tao = $tao;
        return $this;
    }
    /**
     * Get taos
     *
     * @return Collection
     */
    public function getTao()
    {
        return $this->tao;
    }

    public function getTaoId()
    {
        return $this->tao->getId();
    }

    public function removeTao()
    {
        $this->tao = null;
    }

    /**
     *
     * @var string @ORM\Column(name="favoris", type="boolean", nullable=false)
     */
    protected $favoris = false;
    public function getFavoris()
    {
        return $this->favoris;
    }
    public function setFavoris($value)
    {
        $this->favoris = $value;
        return $this;
    }
}
