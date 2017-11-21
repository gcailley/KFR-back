<?php

namespace RoutanglangquanBundle\Form\Dto\Kungfu;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuTaoDTO extends AbstractRtlqDTO {

    protected $nom;
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }

    public  function getNom() {
        return $this->nom;
    }


    protected $nom_chinois;
    public function setNomChinois($value)
    {
        $this->nom_chinois = $value;
        return $this;
    }

    public  function getNomChinois() {
        return $this->nom_chinois;
    }

    protected $description;
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    public  function getDescription() {
        return $this->description;
    }


    protected $style_id;
    public function setStyleId($value)
    {
        $this->style_id = $value;
        return $this;
    }

    public  function getStyleId() {
        return $this->style_id;
    }
    

    protected $style_name;
    public function setStyleName($value)
    {
        $this->style_name = $value;
        return $this;
    }

    public  function getStyleName() {
        return $this->style_name;
    }
    

    protected $niveau_id;
    public function setNiveauId($value)
    {
        $this->niveau_id = $value;
        return $this;
    }

    public  function getNiveauId() {
        return $this->niveau_id;
    }


    protected $niveau_name;
    public function setNiveauName($value)
    {
        $this->niveau_name = $value;
        return $this;
    }

    public  function getNiveauName() {
        return $this->niveau_name;
    }


    protected $arme;
    public function setArme($value)
    {
        $this->arme = $value;
        return $this;
    }

    public  function getArme() {
        return $this->arme;
    }

    protected $arme_url;
    public function setArmeUrl($value)
    {
        $this->arme_url = $value;
        return $this;
    }

    public  function getArmeUrl() {
        return $this->arme_url;
    }

    protected $video_url;
    public function setVideoUrl($value)
    {
        $this->video_url = $value;
        return $this;
    }

    public  function getVideoUrl() {
        return $this->video_url;
    }

    protected $actif;
    public function getActif() {
        return $this->actif;
    }
    public function setActif($value) {
        $this->actif = $value;
        return $this;
    }
}
