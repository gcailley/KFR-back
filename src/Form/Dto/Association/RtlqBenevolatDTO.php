<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqBenevolatDTO extends AbstractRtlqDTO
{
    
    protected $description;
    protected $heure;
    protected $minute;
    protected $date_creation;
    protected $saison_id;
    protected $saison_name;
    protected $adherent_id;
    protected $adherent_name;
    
    
    public function getDescription()
    {
        return $this->description;
    }

    public function getHeure()
    {
        return $this->heure;
    }

    public function getMinute()
    {
        return $this->minute;
    }

    public function getDateCreation()
    {
        return $this->date_creation;
    }

    public function getSaisonId()
    {
        return $this->saison_id;
    }
    
    public function getSaisonName()
    {
        return $this->saison_name;
    }
    public function getAdherentId()
    {
        return $this->adherent_id;
    }
    
    public function getAdherentName()
    {
        return $this->adherent_name;
    }


    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setHeure($value)
    {
        $this->heure = $value;
        return $this;
    }

    public function setMinute($value)
    {
        $this->minute = $value;
        return $this;
    }

    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function setSaisonId($saison_id)
    {
        $this->saison_id = $saison_id;
        return $this;
    }
        
    public function setSaisonName($saison_name)
    {
        $this->saison_name = $saison_name;
        return $this;
    }

    public function setAdherentId($value)
    {
        $this->adherent_id = $value;
        return $this;
    }
        
    public function setAdherentName($value)
    {
        $this->adherent_name = $value;
        return $this;
    }
}
