<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository\Security;

use DateTime;
use Doctrine\ORM\EntityRepository;

/**
 * Description of TresorieRepository.
 *
 * @author GREGORY
 */
class SecurityRepository extends EntityRepository
{
    
    public function findOldToken($adherent, $duree)
    {

        $dateLimite = new DateTime();
        $dateLimite->setTimestamp( time() - $duree);

        $data = $this->createQueryBuilder('s')
                        ->where('s.user = :adherent AND s.createdAt < :duree')
                        ->setParameter('adherent', $adherent)
                        ->setParameter('duree', $dateLimite)
                        ->getQuery()
                        ->getResult();

        return $data;
    }

   
    public function findValideToken($authTokenHeader, $duree)
    {
        $data = $this->createQueryBuilder('s')
                        ->where('s.value = :token AND s.createdAt >= :duree')
                        ->setParameter('token', $authTokenHeader)
                        ->setParameter('duree', time() - $duree)
                        ->getQuery()
                        ->getResult();

        return $data;
    }
    
}
