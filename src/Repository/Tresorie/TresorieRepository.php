<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Repository\Tresorie;

use Doctrine\ORM\EntityRepository;
use App\Entity\Tresorie\RtlqTresorieEtat;
use App\Repository\IKpiRepository;

/**
 * Description of TresorieRepository.
 *
 * @author GREGORY
 */
class TresorieRepository extends EntityRepository implements IKpiRepository
{
    const PATTERN_KPI = 'KPI_TRESORERIE';
    const KPI_TRESORERIE_TOTALE = 'KPI_TRESORERIE_TOTALE';
    const KPI_TRESORERIE_EN_RETARD = 'KPI_TRESORERIE_EN_RETARD';
    const KPI_TRESORERIE_TOTALE_SAISON_COURANTE = 'KPI_TRESORERIE_TOTALE_SAISON_COURANTE';

    public function findAllTresorieFilterByAdherent($adherent_id)
    {
        $query = $this->createQueryBuilder('t')
                        ->innerJoin('t.adherent', 'a')
                        ->where('a.id = :adherent_id')
                        ->setParameter('adherent_id', $adherent_id)
                        ->getQuery()
                        ->getResult();

        return $query;
    }

    public function countByKpi($name)
    {
        if (TresorieRepository::KPI_TRESORERIE_TOTALE == $name) {
            return $this->createQueryBuilder('u')
            ->select('SUM(u.montant)')
            ->innerJoin('u.etat', 'etat')
            ->where('etat IN (:etats)')
            ->setParameter('etats', [RtlqTresorieEtat::ENCAISSE, RtlqTresorieEtat::REGLER])
            ->getQuery()
            ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_EN_RETARD == $name) {
            return $this->createQueryBuilder('u')
            ->select('SUM(u.montant)')
            ->innerJoin('u.etat', 'etat')
            ->where('etat IN (:etats)')
            ->setParameter('etats', [RtlqTresorieEtat::A_ENCAISSER, RtlqTresorieEtat::A_RECLAMER])
            ->getQuery()
            ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_TOTALE_SAISON_COURANTE == $name) {
            return $this->createQueryBuilder('u')
            ->select('SUM(u.montant)')
            ->innerJoin('u.etat', 'etat')
            ->innerJoin('u.saison', 's')
            ->where('etat IN (:etats) AND s.active = :sactive')
            ->setParameter('etats', [RtlqTresorieEtat::ENCAISSE, RtlqTresorieEtat::REGLER])
            ->setParameter('sactive', true)
            ->getQuery()
            ->getSingleScalarResult();
        } 
        
        return -1;
    }
}
