<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqEventDTO extends AbstractRtlqDTO
{
    
    protected $description;
    protected $commentaire;
    protected $adresse;
    protected $date_creation;
    protected $saison_id;
    protected $saison_name;
    
    
    public function getDescription()
    {
        return $this->description;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function getAdresse()
    {
        return $this->adresse;
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


    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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

}
