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
    
    public function extractStats() {

        return $this->createQueryBuilder('u')
            ->select('saison.nom as saison_nom, saison.active as saison_actif, COUNT(DISTINCT(u.id)) as nbCours, SUM(u.nbCoursEssais) as nbCoursEssais, SUM(u.thematique_tao) as nbTao, SUM(u.thematique_application) as nbApp, SUM(u.thematique_combat) as nbCom')
            ->innerJoin('u.saison', 'saison')
            ->groupby('u.saison')
            ->getQuery()
            ->getResult();
    }
}
