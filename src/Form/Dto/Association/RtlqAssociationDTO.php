<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAssociationDTO extends AbstractRtlqDTO
{

    protected $nom;
    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }


    protected $date_creation;
    public function getDateCreation()
    {
        return $this->date_creation;
    }
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;
        return $this;
    }


    protected $active;
    public function getActive()
    {
        return $this->active;
    }
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }


    protected $siege_social;
    public function getSiegeSocial()
    {
        return $this->siege_social;
    }
    public function setSiegeSocial($siegeSocial)
    {
        $this->siege_social = $siegeSocial;
        return $this;
    }


    protected $email;
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    protected $numero_siren;
    public function setNumeroSiren($value)
    {
        $this->numero_siren = $value;
        return $this;
    }
    public function getNumeroSiren()
    {
        return $this->numero_siren;
    }

    protected $url_extranet;
    public function setUrlExtranet($value)
    {
        $this->url_extranet = $value;
        return $this;
    }
    public function getUrlExtranet()
    {
        return $this->url_extranet;
    }


    protected $url_intranet;
    public function setUrlIntranet($value)
    {
        $this->url_intranet = $value;
        return $this;
    }
    public function getUrlIntranet()
    {
        return $this->url_intranet;
    }

    protected $numero_compte_bancaire;
    public function setNumeroCompteBancaire($value)
    {
        $this->numero_compte_bancaire = $value;
        return $this;
    }
    public function getNumeroCompteBancaire()
    {
        return $this->numero_compte_bancaire;
    }

    protected $president_id;
    public function setPresidentId($value)
    {
        $this->president_id = $value;
        return $this;
    }
    public function getPresidentId()
    {
        return $this->president_id;
    }

    protected $president_nom_prenom;
    public function setPresidentNomPrenom($value)
    {
        $this->president_nom_prenom = $value;
        return $this;
    }
    public function getPresidentNomPrenom()
    {
        return $this->president_nom_prenom;
    }

    protected $secretaire_id;
    public function setSecretaireId($value)
    {
        $this->secretaire_id = $value;
        return $this;
    }
    public function getSecretaireId()
    {
        return $this->secretaire_id;
    }

    protected $secretaire_nom_prenom;
    public function setSecretaireNomPrenom($value)
    {
        $this->secretaire_nom_prenom = $value;
        return $this;
    }
    public function getSecretaireNomPrenom()
    {
        return $this->secretaire_nom_prenom;
    }

    protected $tresorier_id;
    public function setTresorierId($value)
    {
        $this->tresorier_id = $value;
        return $this;
    }
    public function getTresorierId()
    {
        return $this->tresorier_id;
    }

    protected $tresorier_nom_prenom;
    public function setTresorierNomPrenom($value)
    {
        $this->tresorier_nom_prenom = $value;
        return $this;
    }
    public function getTresorierNomPrenom()
    {
        return $this->tresorier_nom_prenom;
    }


    protected $closed;
    public function getClosed()
    {
        return $this->closed;
    }
    public function setClosed($value)
    {
        $this->closed = $value;
        return $this;
    }

    protected $message;
    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($value)
    {
        $this->message = $value;
        return $this;
    }
}
