<?php

namespace RoutanglangquanBundle\Entity\Association;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RoutanglangquanBundle\Entity\AbstractRtlqEntity;

/**
 * RtlqNews
 *
 * @ORM\Table(name="rtlq_news")
 * @ORM\Entity
 */
class RtlqNews extends AbstractRtlqEntity
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
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description;

    /**
     *
     * @var boolean @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var date
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1000, nullable=true)
     */
    private $link;
    

    public function __construct()
    {
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title ;
    }


    public function getDescription()
    {
        return $this->description ;
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function getLink()
    {
        return $this->link;
    }

    
    /**
     * Get actif
     *
     * @return boolean
     */
    public function isActif()
    {
        return $this->actif;
    }
}
