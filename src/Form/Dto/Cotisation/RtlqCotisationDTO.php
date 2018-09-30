<?php

namespace App\Form\Dto\Cotisation;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqCotisationDTO extends AbstractRtlqDTO
{
    
    protected $description;
    protected $cotisation;
    protected $type;
    protected $nb_cheque;
    protected $repartition_cheque;
    protected $active;
    protected $saison_id;
    protected $saison_name;
    protected $categorie_id;
    protected $categorie_name;
    
    
    public function getDescription()
    {
        return $this->description;
    }

    public function getCotisation()
    {
        return $this->cotisation;
    }

    public function getRepartitionCheque()
    {
        return $this->repartition_cheque;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getSaisonId()
    {
        return $this->saison_id;
    }
    
    public function getSaisonName()
    {
        return $this->saison_name;
    }

    public function getCategorieId()
    {
        return $this->categorie_id;
    }

    public function getCategorieName()
    {
        return $this->categorie_name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setCotisation($cotisation)
    {
        $this->cotisation = $cotisation;
        return $this;
    }

    public function setRepartitionCheque($repartitionCheque)
    {
        $this->repartition_cheque = $repartitionCheque;
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function setSaisonId($saison_id)
    {
        $this->saison_id = $saison_id;
        return $this;
    }

    public function setCategorieId($categorie_id)
    {
        $this->categorie_id = $categorie_id;
        return $this;
    }

        
    public function setSaisonName($saison_name)
    {
        $this->saison_name = $saison_name;
        return $this;
    }

    public function setCategorieName($categorie_name)
    {
        $this->categorie_name = $categorie_name;
        return $this;
    }


    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getNbCheque()
    {
        return $this->nb_cheque;
    }

    public function setNbCheque($value)
    {
        $this->nb_cheque = $value;
        return $this;
    }
}
