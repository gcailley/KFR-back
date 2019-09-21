<?php

namespace App\Form\Dto\Saison;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqCategorieVoteeDTO extends AbstractRtlqDTO {
	
    
    public function __construct() {
    }

	protected $categorie_id;
    public function setCategorieId($categorieId) {
        $this->categorie_id = $categorieId;

        return $this;
    }
    public function getCategorieId() {
        return $this->categorie_id;
    }

	protected $categorie_name;
    public function setCategorieName($categorie_name) {
        $this->categorie_name = $categorie_name;
        return $this;
    }
    public function getCategorieName() {
        return $this->categorie_name;
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

    protected $montant;
    public function getMontant() {
        return $this->montant;
    }
    public function setMontant($value) {
        $this->montant = $value;
        return $this;
    }
}
