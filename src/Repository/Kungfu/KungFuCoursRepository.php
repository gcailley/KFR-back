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
class KungFuCoursRepository extends EntityRepository {
       
    public function extractNbCoursSaisonCourante()
    {
        // TODO faire un count
        $query = $this->createQueryBuilder('t')
                        ->where('t.actif = :actif')
                        ->setParameter('actif', true)
                        ->getQuery()
                        ->getResult();

        return sizeof($query);
    }

}
