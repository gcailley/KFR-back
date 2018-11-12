<?php

namespace App\Form\Dto\Materiel;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqAchatMaterielDTO extends AbstractRtlqDTO {


    protected $adherent_id;
    public function setAdherentId($value)
    {
        $this->adherent_id = $value;
        return $this;
    }
    public  function getAdherentId() {
        return $this->adherent_id;
    }

    protected $magasin;
    public function setMagasin($value)
    {
        $this->magasin = $value;
        return $this;
    }
    public function getMagasin() {
        return $this->magasin;
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

    protected $date_achat;
    public function setDateAchat($value)
    {
        $this->date_achat = $value;
        return $this;
    }
    public  function getDateAchat() {
        return $this->date_achat;
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
