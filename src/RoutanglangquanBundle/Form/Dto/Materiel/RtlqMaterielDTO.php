<?php

namespace RoutanglangquanBundle\Form\Dto\Materiel;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

class RtlqMaterielDTO extends AbstractRtlqDTO {


    protected $nom;
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }
    public  function getNom() {
        return $this->nom;
    }

    protected $prix_achat;
    public function setPrixAchat($value)
    {
        $this->prix_achat = $value;
        return $this;
    }
    public  function getPrixAchat() {
        return $this->prix_achat;
    }

    protected $prix_vente;
    public function setPrixVente($value)
    {
        $this->prix_vente = $value;
        return $this;
    }
    public  function getPrixVente() {
        return $this->prix_vente;
    }
 
    protected $stock = 0;
    public function getStock() {
        return $this->stock;
    }
    public function setStock($value) {
        $this->stock = $value;
        return $this;
    }

    protected $association = false;
    public function setAssociation($value)
    {
        $this->association = $value;
        return $this;
    }
    public  function getAssociation() {
        return $this->association;
    }


    protected $date_achat;
    public function setDateAchat($value)
    {
        $this->date_achat = $value;
        return $this;
    }
    public  function getDateAchat() {
        return $this->date_achat;
    }
}
