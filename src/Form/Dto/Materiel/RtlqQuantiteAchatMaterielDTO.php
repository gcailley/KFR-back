<?php

namespace App\Form\Dto\Materiel;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqQuantiteAchatMaterielDTO extends AbstractRtlqDTO {
   
    protected $nom = "";
    public function setNom($value)
    {
        $this->nom = $value;
        return $this;
    }
    public  function getNom() {
        return $this->nom;
    }


    protected $nombre = "";
    public function setNombre($value)
    {
        $this->nombre = $value;
        return $this;
    }
    public  function getNombre() {
        return $this->nombre;
    }
}
