<?php

namespace App\Form\Dto\Kungfu;

use App\Form\Dto\AbstractRtlqDTO;

class RtlqKungfuAdherentTaoDTO extends AbstractRtlqDTO {

    protected $niveau;
    public function setNiveau($value)
    {
        $this->niveau = $value;
        return $this;
    }

    public  function getNiveau() {
        return $this->niveau;
    }


    protected $nb_revision;
    public function setNbRevision($value)
    {
        $this->nb_revision = $value;
        return $this;
    }

    public  function getNbRevision() {
        return $this->nb_revision;
    }

    protected $adherent_id;
    public function setAdherentId($value)
    {
        $this->adherent_id = $value;
        return $this;
    }

    public  function getAdherentId() {
        return $this->adherent_id;
    }
    

    protected $tao_id;
    public function setTaoId($value)
    {
        $this->tao_id = $value;
        return $this;
    }

    public  function getTaoId() {
        return $this->tao_id;
    }

}
