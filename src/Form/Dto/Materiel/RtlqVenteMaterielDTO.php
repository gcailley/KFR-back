<?php

namespace App\Form\Dto\Materiel;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqVenteMaterielDTO extends AbstractRtlqDTO {


    protected $adherent_id;
    public function setAdherentId($value)
    {
        $this->adherent_id = $value;
        return $this;
    }
    public  function getAdherentId() {
        return $this->adherent_id;
    }

    protected $montant_total;
    public function setMontantTotal($value)
    {
        $this->montant_total = $value;
        return $this;
    }
    public  function getMontantTotal() {
        return $this->montant_total;
    }

    protected $date_vente;
    public function setDateVente($value)
    {
        $this->date_vente = $value;
        return $this;
    }
    public  function getDateVente() {
        return $this->date_vente;
    }

    protected $prix_association = false;
    public function setPrixAssociation($value)
    {
        $this->prix_association = $value;
        return $this;
    }
    public  function getPrixAssociation() {
        return $this->prix_association;
    }
    
    protected $cheque = false;
    public function setCheque($value)
    {
        $this->cheque = $value;
        return $this;
    }
    public  function getCheque() {
        return $this->cheque;
    }

    
    protected $numero_cheque = "";
    public function setNumeroCheque($value)
    {
        $this->numero_cheque = $value;
        return $this;
    }
    public  function getNumeroCheque() {
        return $this->numero_cheque;
    }

    protected $materiels = array();
    public function setMateriels($value)
    {
        $this->materiels = $value;
        return $this;
    }
    public  function getMateriels() {
        return $this->materiels;
    }


}
