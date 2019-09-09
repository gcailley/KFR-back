<?php

namespace App\Form\Dto\Kungfu;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuCoursDTO extends AbstractRtlqDTO {


    protected $description;
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    public  function getDescription() {
        return $this->description;
    }

    
    protected $nb_cours_essais;
    public function setNbCoursEssais($value)
    {
        $this->nb_cours_essais = $value;
        return $this;
    }

    public  function getNbCoursEssais() {
        return $this->nb_cours_essais;
    }

    protected $thematique_tao;
    public function setthematiqueTao($value)
    {
        $this->thematique_tao = $value;
        return $this;
    }

    public  function getthematiqueTao() {
        return $this->thematique_tao;
    }

    protected $thematique_application;
    public function setthematiqueApplication($value)
    {
        $this->thematique_application = $value;
        return $this;
    }

    public  function getthematiqueApplication() {
        return $this->thematique_application;
    }

    protected $thematique_combat;
    public function setThematiqueCombat($value)
    {
        $this->thematique_combat = $value;
        return $this;
    }

    public  function getThematiqueCombat() {
        return $this->thematique_combat;
    }
    

    protected $saison_name;
    public function setSaisonName($value)
    {
        $this->saison_name = $value;
        return $this;
    }

    public  function getSaisonName() {
        return $this->saison_name;
    }
    

    protected $saison_id;
    public function setSaisonId($value)
    {
        $this->saison_id = $value;
        return $this;
    }

    public  function getSaisonId() {
        return $this->saison_id;
    }

    protected $date;
    public function getDate() {
        return $this->date;
    }
    public function setDate($value) {
        $this->date = $value;
        return $this;
    }
}
