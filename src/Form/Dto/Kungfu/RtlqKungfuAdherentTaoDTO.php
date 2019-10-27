<?php

namespace App\Form\Dto\Kungfu;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuAdherentTaoDTO extends AbstractRtlqDTO {

    protected $niveau;
    public function setNiveau($value)
    {
        $this->niveau = $value;
        return $this;
    }

    public  function getNiveau() {
        return $this->niveau;
    }


    protected $nb_revision;
    public function setNbRevision($value)
    {
        $this->nb_revision = $value;
        return $this;
    }

    public  function getNbRevision() {
        return $this->nb_revision;
    }

    protected $adherent_id;
    public function setAdherentId($value)
    {
        $this->adherent_id = $value;
        return $this;
    }

    public  function getAdherentId() {
        return $this->adherent_id;
    }
    

    protected $tao_id;
    public function setTaoId($value)
    {
        $this->tao_id = $value;
        return $this;
    }

    public  function getTaoId() {
        return $this->tao_id;
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

    protected $nom_chinois;
    public function setNomChinois($value)
    {
        $this->nom_chinois = $value;
        return $this;
    }

    public  function getNomChinois() {
        return $this->nom_chinois;
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
    
    protected $traduction;
    public function setTraduction($value)
    {
        $this->traduction = $value;
        return $this;
    }

    public  function getTraduction() {
        return $this->traduction;
    }
}
