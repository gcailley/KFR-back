<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RoutanglangquanBundle\Repository\Tresorie;

use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie;

/**
 * Description of TresorieRepository
 *
 * @author GREGORY
 */
class TresorieRepository extends EntityRepository {

    public function findAllTresorieFilterByAdherent($adherent_id) {

        $request = 'SELECT s FROM RoutanglangquanBundle:Tresorie\RtlqTresorie s WHERE s.adherent_id=:adherent_id';
        return $this->getEntityManager()
                        ->createQuery($request)
                        ->setParameter("adherent_id", $adherent_id)
                        ->getResult();
    }

}
