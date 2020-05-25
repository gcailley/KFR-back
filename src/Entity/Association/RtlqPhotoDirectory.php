<?php

namespace App\Entity\Association;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\AbstractRtlqEntity;

/**
 * RtlqNews
 *
 * @ORM\Table(name="rtlq_photo_directories")
 * @ORM\Entity
 */
class RtlqPhotoDirectory extends AbstractRtlqEntity
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=1000, nullable=true)
     */
    private $name;
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }


    /**
     *
     * @var boolean @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;
    public function getActif()
    {
        return $this->actif;
    }
    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Association\RtlqPhoto", mappedBy="repertoire", cascade={"persist"})
     */
    private $photos;
    public function getPhotos()
    {
        return $this->photos;
    }
    public function setPhotos($photos)
    {
        $this->photos = $photos;
        return $this;
    }

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

}
