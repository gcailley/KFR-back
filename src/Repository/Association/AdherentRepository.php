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
 * Description of AdherentRepository.
 *
 * @author GREGORY
 */
class AdherentRepository extends EntityRepository implements UserLoaderInterface, IKpiRepository
{
    const PATTERN_KPI = 'KPI_USER';
    const KPI_USER_ACTIF = 'KPI_USER_ACTIF';

    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
              ->where('u.username = :username OR u.email = :username')
              ->setParameter('username', $username)
              ->getQuery()
              ->getOneOrNullResult();
    }

    public function loadUserByUsernameAndPassword($username, $password)
    {
        return $this->createQueryBuilder('u')
              ->where('(u.username = :username OR u.email = :username) AND (u.password = :password)')
              ->setParameter('username', $username)
              ->setParameter('password', $password)
              ->getQuery()
              ->getOneOrNullResult();
    }

    public function countByKpi($name)
    {

        if (AdherentRepository::KPI_USER_ACTIF == $name) {
            return $this->createQueryBuilder('u')
              ->select('count(u)')
              ->innerJoin('u.saisons', 's')
              ->where('u.actif = :uactif AND s.active = :sactive')
              ->setParameter('uactif', true)
              ->setParameter('sactive', true)
              ->getQuery()
              ->getSingleScalarResult();
        }

        return -1;
    }
}
