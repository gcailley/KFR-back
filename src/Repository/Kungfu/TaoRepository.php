<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository\Kungfu;

use Doctrine\ORM\EntityRepository;

/**
 * Description of TaoRepository
 *
 * @author GREGORY
 */
class TaoRepository extends EntityRepository {
   
    public function findAllTaoFilterByAdherent($adherent_id)
    {
        $query = $this->createQueryBuilder('t')
                        ->innerJoin('t.adherent', 'a')
                        ->where('a.id = :adherent_id')
                        ->setParameter('adherent_id', $adherent_id)
                        ->getQuery()
                        ->getResult();

        return $query;
    }
}
