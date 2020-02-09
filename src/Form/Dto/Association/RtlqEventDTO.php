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
    protected $adherents;
    protected $nb_accompagnants = 0;
    protected $nb_people = 0;

    public function __construct()
    {
        $this->adherents = [];
    }
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

    public function getAdherents()
    {
        return $this->adherents;
    }

    public function addAdherent($adherent)
    {
        $this->adherents[] = $adherent;
        $this->updatePeople();
        return $this;
    }

    public function setAdherents($adherents)
    {
        $this->adherents = $adherents;
        $this->updatePeople();
        return $this;
    }

    private function updatePeople()
    {
        $this->nb_people = sizeof($this->adherents) + $this->nb_accompagnants;
    }

    public function setNbAccompagnants($value)
    {
        $this->nb_accompagnants = $value;
        $this->updatePeople();
        return $this;
    }

    public function getNbAccompagnants()
    {
        return $this->nb_accompagnants;
    }
    
    public function getNbPeople()
    {
        return $this->nb_people;
    }
    public function setNbPeople($value)
    {
        $this->nb_people = $value;
        return $this;
    }

}
