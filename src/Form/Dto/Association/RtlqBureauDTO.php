<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqBureauDTO extends AbstractRtlqDTO
{

    
    public function __construct()
    {
        $this->saisons = [];
    }


    protected $date_creation;
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    protected $date_fin;
    public function getDateFin()
    {
        return $this->date_fin;
    }
    public function setDateFin($date_fin)
    {
        $this->date_fin = $date_fin;
        return $this;
    }


    protected $president_id;
    public function getPresidentId()
    {
        return $this->president_id;
    }

    public function setPresidentId($id)
    {
        $this->president_id = $id;
        return $this;
    }

    protected $president_name;
    public function getPresidentName()
    {
        return $this->president_name;
    }

    public function setPresidentName($name)
    {
        $this->president_name = $name;
        return $this;
    }
    
    protected $actif = false;
    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($value)
    {
        $this->actif = $value;
        return $this;
    }

    
    protected $tresorier_id;
    public function getTresorierId()
    {
        return $this->tresorier_id;
    }

    public function setTresorierId($id)
    {
        $this->tresorier_id = $id;
        return $this;
    }

    protected $tresorier_name;
    public function getTresorierName()
    {
        return $this->tresorier_name;
    }

    public function setTresorierName($name)
    {
        $this->tresorier_name = $name;
        return $this;
    }


    protected $secretaire_id;
    public function getSecretaireId()
    {
        return $this->secretaire_id;
    }

    public function setSecretaireId($id)
    {
        $this->secretaire_id = $id;
        return $this;
    }

    protected $secretaire_name;
    public function getSecretaireName()
    {
        return $this->secretaire_name;
    }

    public function setSecretaireName($name)
    {
        $this->secretaire_name = $name;
        return $this;
    }

    protected $saisons;
    public function addSaison($id)
    {
        $this->saisons[] = $id;
        return $this;
    }
    public function getSaisons()
    {
        return $this->saisons;
    }
    public function setSaisons($saisons) {
        $this->saisons = $saisons;
        $this->nb_saisons = sizeof($this->saisons);
        return $this;
    }


}
