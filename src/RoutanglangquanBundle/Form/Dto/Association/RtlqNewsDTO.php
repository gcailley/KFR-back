<?php

namespace RoutanglangquanBundle\Form\Dto\Association;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqNewsDTO extends AbstractRtlqDTO
{
    
    protected $title;
    protected $description;
    protected $link;
    protected $date_creation;
    protected $actif;

    
    public function __construct()
    {
        $this->adherents = [];
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }
    
    public function getLink()
    {
        return $this->link;
    }
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function isActif()
    {
        return $this->actif;
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
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;
        return $this;
    }
}
