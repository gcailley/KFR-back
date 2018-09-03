<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository\Association;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use App\Entity\Association\RtlqAdherent;

/**
 * Description of AdherentRepository
 *
 * @author GREGORY
 */
class AdherentRepository extends EntityRepository implements UserLoaderInterface
  {
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


}
