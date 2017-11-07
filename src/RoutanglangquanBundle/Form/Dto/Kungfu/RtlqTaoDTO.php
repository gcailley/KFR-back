<?php

namespace RoutanglangquanBundle\Form\Dto\Kungfu;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuDTO extends AbstractRtlqDTO {
    private $id;
    public function setId($value)
    {
        $this->$id = $value;
        return $this;
    }

    public  function getId() {
        return $this->$id;
    }

    private $nom;
    public function setNom($value)
    {
        $this->$nom = $value;
        return $this;
    }

    public  function getNom() {
        return $this->$nom;
    }


    private $nom_chinois;
    public function setNomChinois($value)
    {
        $this->$nom_chinois = $value;
        return $this;
    }

    public  function getNomChinois() {
        return $this->$nom_chinois;
    }

    private $description;
    public function setDescription($value)
    {
        $this->$description = $value;
        return $this;
    }

    public  function getDescription() {
        return $this->$description;
    }


    private $style_id;
    public function setStyleId($value)
    {
        $this->$style_id = $value;
        return $this;
    }

    public  function getStyleId() {
        return $this->$style_id;
    }
    

    private $style_name;
    public function setStyleName($value)
    {
        $this->$style_name = $value;
        return $this;
    }

    public  function getStyleName() {
        return $this->$style_name;
    }
    

    private $niveau_id;
    public function setNiveauId($value)
    {
        $this->$niveau_id = $value;
        return $this;
    }

    public  function getNiveauId() {
        return $this->$niveau_id;
    }


    private $niveau_name;
    public function setNiveauName($value)
    {
        $this->$niveau_name = $value;
        return $this;
    }

    public  function getNiveauName() {
        return $this->$niveau_name;
    }


    private $arme;
    public function setArme($value)
    {
        $this->$arme = $value;
        return $this;
    }

    public  function getArme() {
        return $this->$arme;
    }

    private $arme_url;
    public function setArmeUrl($value)
    {
        $this->$arme_url = $value;
        return $this;
    }

    public  function getArmeUrl() {
        return $this->$arme_url;
    }

    private $video_url;
    public function setVideoUrl($value)
    {
        $this->$video_url = $value;
        return $this;
    }

    public  function getVideoUrl() {
        return $this->$video_url;
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
