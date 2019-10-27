<?php

namespace App\Form\Dto\Kungfu;

use App\Form\Dto\AbstractRtlqDTO;

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

    protected $traduction;
    public function setTraduction($value)
    {
        $this->traduction = $value;
        return $this;
    }

    public  function getTraduction() {
        return $this->traduction;
    }

    protected $pinyin;
    public function setPinyin($value)
    {
        $this->pinyin = $value;
        return $this;
    }

    public  function getPinyin() {
        return $this->pinyin;
    }

    protected $origine;
    public function setOrigine($value)
    {
        $this->origine = $value;
        return $this;
    }

    public  function getOrigine() {
        return $this->origine;
    }

    protected $combine;
    public function setCombine($value)
    {
        $this->combine = $value;
        return $this;
    }

    public  function getCombine() {
        return $this->combine;
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
