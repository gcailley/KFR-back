<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RoutanglangquanBundle\Repository\Saison;

use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Entity\Saison\RtlqSaison;

/**
 * Description of SaisonRepository
 *
 * @author GREGORY
 */
class SaisonRepository extends EntityRepository {

    public function findAllSeasonFilterByActive($active) {

        $request = 'SELECT s FROM RoutanglangquanBundle:Saison\RtlqSaison s WHERE s.active';
        $request .= $active ? "=true" : "=false";
        return $this->getEntityManager()
                        ->createQuery($request)
                        ->getResult();
    }

}
