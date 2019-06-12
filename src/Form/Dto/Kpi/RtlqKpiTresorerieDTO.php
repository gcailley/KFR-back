<?php

namespace App\Form\Dto\Kpi;

class RtlqKpiTresorerieDTO implements \JsonSerializable {

    protected $saison_name;
    public function setSaisonName($value)
    {
        $this->saison_name = $value;
        return $this;
    }
    public  function getSaisonName() {
        return $this->saison_name;
    }

    protected $summary_pointe;
    public function setSummaryPointee($value)
    {
        $this->summary_pointe = $value;
        return $this;
    }
    public  function getSummaryPointee() {
        return $this->summary_pointe;
    }

    protected $summary_non_pointe;
    public function setSummaryNonPointee($value)
    {
        $this->summary_non_pointe = $value;
        return $this;
    }
    public  function getSummaryNonPointee() {
        return $this->summary_non_pointe;
    }

    protected $summary_totale_previsionnelle;
    public function setSummaryTotalePrevisionnelle($value)
    {
        $this->summary_totale_previsionnelle = $value;
        return $this;
    }
    public  function getSummaryTotalePrevisionnelle() {
        return $this->summary_totale_previsionnelle;
    }

    protected $summary_etats;
    public function setSummaryEtats($value)
    {
        $this->summary_etats = $value;
        return $this;
    }
    public  function getSummaryEtats() {
        return $this->summary_etats;
    }



    public function jsonSerialize() {
		$vars = get_object_vars ( $this );
		
		return $vars;
	}

}