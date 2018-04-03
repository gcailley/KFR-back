<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RoutanglangquanBundle\Repository\Association;

use Doctrine\ORM\EntityRepository;
use RoutanglangquanBundle\Entity\Association\RtlqNews;

/**
 * Description of NewsRepository
 *
 * @author GREGORY
 */
class NewsRepository extends EntityRepository
  {
      public function loadLastestNews($jours=30)
      {
          return $this->createQueryBuilder('n')
              ->where('n.actif = :actif AND n.dateCreation >= :dateCreation')
              ->setParameter('actif', true)
              ->setParameter('dateCreation', date('Y-m-d', strtotime("-$jours days")))
              ->getQuery()
              ->getResult();

      }
}
