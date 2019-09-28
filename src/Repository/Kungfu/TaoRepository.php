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
   
    public function findAllTaoFilterByAdherent($adherentId)
    {
        $query = $this->createQueryBuilder('t')
                        ->innerJoin('t.adherents', 'a')
                        ->where('a.id = :adherentId')
                        ->setParameter('adherentId', $adherentId)
                        ->getQuery()
                        ->getResult();

        return $query;
    }
}
