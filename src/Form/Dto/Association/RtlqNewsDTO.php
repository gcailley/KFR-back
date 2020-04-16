<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqNewsDTO extends AbstractRtlqDTO
{

    public function __construct()
    {
    }

    protected $title;
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    protected $description;
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    protected $link;
    public function getLink()
    {
        return $this->link;
    }
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    protected $actif;
    public function isActif()
    {
        return $this->actif;
    }
    public function setActif($actif)
    {
        $this->actif = $actif;
        return $this;
    }

    protected $date_creation;
    public function getDateCreation()
    {
        return $this->date_creation;
    }
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;
        return $this;
    }
}
