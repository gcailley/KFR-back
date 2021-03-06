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
    const KPI_TRESORERIE_SAISON_COURANTE_PREVISIONNELLE = 'KPI_TRESORERIE_SAISON_COURANTE_PREVISIONNELLE';
    const KPI_TRESORERIE_SAISON_COURANTE_A_DATE = 'KPI_TRESORERIE_SAISON_COURANTE_A_DATE';
    const KPI_TRESORERIE_TOTALE_POINTEE = 'KPI_TRESORERIE_TOTALE_POINTEE';
    const KPI_TRESORERIE_TOTALE_NON_POINTEE = 'KPI_TRESORERIE_TOTALE_NON_POINTEE';

    public function getAllKpis()
    {
        return [
            TresorieRepository::KPI_TRESORERIE_TOTALE, TresorieRepository::KPI_TRESORERIE_EN_RETARD, TresorieRepository::KPI_TRESORERIE_SAISON_COURANTE_PREVISIONNELLE, TresorieRepository::KPI_TRESORERIE_SAISON_COURANTE_A_DATE, TresorieRepository::KPI_TRESORERIE_TOTALE_POINTEE, TresorieRepository::KPI_TRESORERIE_TOTALE_NON_POINTEE
        ];
    }
    public function findAllTresorieFilterByAdherent($adherent_id)
    {
        $query = $this->createQueryBuilder('t')
            ->innerJoin('t.adherent', 'a')
            ->where('a.id = :adherent_id')
            ->setParameter('adherent_id', $adherent_id)
            ->addOrderBy('t.etat', 'DESC')
            ->addOrderBy('t.dateCreation', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }

    public function infoTresorieEnRetardFilterByAdherent($adherent_id)
    {
        return $this->createQueryBuilder('u')
            ->select('SUM(u.montant) as montant, MIN(u.dateCreation) as date')
            ->innerJoin('u.adherent', 'a')
            ->innerJoin('u.etat', 'etat')
            ->where('a.id = :adherent_id AND etat IN (:etats)')
            ->setParameter('adherent_id', $adherent_id)
            ->setParameter('etats', [RtlqTresorieEtat::A_ENCAISSER, RtlqTresorieEtat::A_RECLAMER])
            ->getQuery()
            ->getResult();
    }

    public function extractStats()
    {
        $data = [];
        foreach ($this->getAllKpis() as $key => $value) {
            $dataValue = $this->countByKpi($value);
            if ($dataValue == null) {
                $dataValue = 0;
            } 
            $data[$value] = round($dataValue, 0);
        }
        return $data;
    }

    public function countByKpi($name)
    {
        if (TresorieRepository::KPI_TRESORERIE_TOTALE == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->where('etat NOT IN (:etats)')
                ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
                ->getQuery()
                ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_EN_RETARD == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->where('etat IN (:etats) AND u.dateCreation <= CURRENT_DATE()')
                ->setParameter('etats', [RtlqTresorieEtat::A_ENCAISSER, RtlqTresorieEtat::A_RECLAMER, RtlqTresorieEtat::A_REGLER])
                ->getQuery()
                ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_SAISON_COURANTE_PREVISIONNELLE == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->innerJoin('u.saison', 's')
                ->where('etat NOT IN (:etats) AND s.active = :sactive')
                ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
                ->setParameter('sactive', true)
                ->getQuery()
                ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_SAISON_COURANTE_A_DATE == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->innerJoin('u.saison', 's')
                ->where('etat NOT IN (:etats) AND s.active = :sactive AND u.dateCreation <= CURRENT_DATE()')
                ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
                ->setParameter('sactive', true)
                ->getQuery()
                ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_TOTALE_POINTEE == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->where('etat NOT IN (:etats) AND u.pointe = :spointe')
                ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
                ->setParameter('spointe', true)
                ->getQuery()
                ->getSingleScalarResult();
        } else if (TresorieRepository::KPI_TRESORERIE_TOTALE_NON_POINTEE == $name) {
            return $this->createQueryBuilder('u')
                ->select('SUM(u.montant)')
                ->innerJoin('u.etat', 'etat')
                ->where('etat NOT IN (:etats) AND u.pointe = :spointe')
                ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
                ->setParameter('spointe', false)
                ->getQuery()
                ->getSingleScalarResult();
        }

        return -1;
    }


    function extractAllKpis()
    {
        return $this->createQueryBuilder('u')
            ->select('saison.nom as saison_name, etat.value as etat_name, u.pointe as pointe, SUM(u.montant) as montant')
            ->innerJoin('u.etat', 'etat')
            ->innerJoin('u.saison', 'saison')
            ->groupby('saison.id,etat.id,u.pointe')
            ->getQuery()
            ->getResult();
    }

    function extractMontantsDepenseParCategories($idSaison)
    {
        return
            $this->createQueryBuilder('u')
            ->select('c.id as categorie_id, SUM(u.montant) as montant')
            ->innerJoin('u.etat', 'etat')
            ->innerJoin('u.saison', 's')
            ->innerJoin('u.categorie', 'c')
            ->where('etat NOT IN (:etats) AND s.id = :idSaison')
            ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
            ->setParameter('idSaison', $idSaison)
            ->groupby('u.categorie')
            ->getQuery()
            ->getResult();
    }

    function extractMontantsDepenseParSaisons()
    {
        return
            $this->createQueryBuilder('u')
            ->select('s.id as saison_id, s.nom as saison_name, SUM(u.montant) as montant')
            ->innerJoin('u.etat', 'etat')
            ->innerJoin('u.saison', 's')
            ->where('etat NOT IN (:etats)')
            ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
            ->groupby('u.saison')
            ->getQuery()
            ->getResult();
    }

    function extractMontantsDepenseParSaison($idSaison)
    {
        return
            $this->createQueryBuilder('u')
            ->select('u.dateCreation as month, SUM(u.montant) as montant')
            ->innerJoin('u.etat', 'etat')
            ->innerJoin('u.saison', 's')
            ->where('etat NOT IN (:etats) AND s.id = :idSaison')
            ->setParameter('etats', [RtlqTresorieEtat::ANNULE])
            ->setParameter('idSaison', $idSaison)
            ->groupby('month')
            ->orderBy('month', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
