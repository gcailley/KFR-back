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
class AdherentTaoRepository extends EntityRepository
{

    public function findAllTaoFilterByAdherent($adherentId)
    {
        $query = $this->createQueryBuilder('at')
            ->innerJoin('at.adherent', 'a')
            ->innerJoin('at.tao', 't')
            ->where('a.id = :adherentId')
            ->setParameter('adherentId', $adherentId)
            ->getQuery()
            ->getResult();

        return $query;
    }

    public function countAllTaoFilterByAdherent($adherentId)
    {
        // TODO faire un count
        $query = $this->createQueryBuilder('at')
            ->innerJoin('at.adherent', 'a')
            ->where('a.id = :adherentId')
            ->setParameter('adherentId', $adherentId)
            ->getQuery()
            ->getResult();

        return sizeof($query);
    }
}
