<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository\Association;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use App\Repository\IKpiRepository;

/**
 * Description of BureauRepository.
 *
 * @author GREGORY
 */
class BureauRepository extends EntityRepository
{
    public function getBureauActif()
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.saisons', 's')
            ->where('s.active = :sactive')
            ->setParameter('sactive', true)
            ->getQuery()
            ->getOneOrNullResult();
    }
}