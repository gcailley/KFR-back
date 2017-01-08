<?php

namespace RoutanglangquanBundle\Form\Dto\Cotisation;

use RoutanglangquanBundle\Form\Dto\AbstractRtlqDTO;

/**
 * @author GREGORY
 *
 */
class RtlqCotisationDTO extends AbstractRtlqDTO {
	
	protected $description;
	protected $cotisation;
	protected $repartitionCheque;
	protected $active;
	protected $saison_id;
	protected $categorie_id;
	
        public function getDescription() {
            return $this->description;
        }

        public function getCotisation() {
            return $this->cotisation;
        }

        public function getRepartitionCheque() {
            return $this->repartitionCheque;
        }

        public function getActive() {
            return $this->active;
        }

        public function getSaisonId() {
            return $this->saison_id;
        }

        public function getCategorieId() {
            return $this->categorie_id;
        }

        public function setDescription($description) {
            $this->description = $description;
            return $this;
        }

        public function setCotisation($cotisation) {
            $this->cotisation = $cotisation;
            return $this;
        }

        public function setRepartitionCheque($repartitionCheque) {
            $this->repartitionCheque = $repartitionCheque;
            return $this;
        }

        public function setActive($active) {
            $this->active = $active;
            return $this;
        }

        public function setSaisonId($saison_id) {
            $this->saison_id = $saison_id;
            return $this;
        }

        public function setCategorieId($categorie_id) {
            $this->categorie_id = $categorie_id;
            return $this;
        }


}
