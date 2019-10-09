<?php

namespace App\Form\Dto\Association;

use App\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqAdherentStatsDTO extends AbstractRtlqDTO {

    public function __construct($nbTaoUser, $nbTao, $tresorerieRetard, $prochaineEcheance) {
        $this->nb_tao_user = $nbTaoUser;
        $this->nb_tao = $nbTao;
        $this->tresorerie_retard = $tresorerieRetard;
        $this->prochaine_echeance = $prochaineEcheance;
    }


    protected $nb_tao_user;

    public function getNbTaoUser() {
        return $this->nb_tao_user;
    }
    public function setNbTaoUser($value) {
        $this->nb_tao_user = $value;
        return $this;
    }

    protected $nb_tao;

    public function getNbTao() {
        return $this->nb_tao;
    }
    public function setNbTao($value) {
        $this->nb_tao = $value;
        return $this;
    }
    

    protected $tresorerie_retard;

    public function getTresorerieRetard() {
        return $this->tresorerie_retard;
    }
    public function setTresorerieRetard($value) {
        $this->tresorerie_retard = $value;
        return $this;
    }
    

    protected $prochaine_echeance;

    public function getProchaineEcheance() {
        return $this->prochaine_echeance;
    }
    public function setProchaineEcheance($value) {
        $this->prochaine_echeance = $value;
        return $this;
    }
    
    
}

