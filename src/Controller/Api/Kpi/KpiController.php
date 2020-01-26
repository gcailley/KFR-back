<?php

namespace App\Controller\Api\Kpi;

use App\Controller\Api\AbstractRtlqController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\json_encode;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Association\RtlqAdherent;
use App\Entity\Kungfu\RtlqKungfuCours;
use App\Repository\Tresorie\TresorieRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repository\Association\AdherentRepository;
use App\Form\Dto\Kpi\RtlqKpiTresorerieDTO;

/**
 * @Route("/kpis")
 */
class KpiController extends AbstractRtlqController
{
    /**
     * @Route("/tresoreries", methods={"GET"})
     */
    public function extractTersorerieKpi()
    {
        $repositorie = $this->getDoctrine()->getRepository(RtlqTresorie::class);
        $results = $repositorie->extractAllKpis();

        return  $this->newResponse($results, Response::HTTP_ACCEPTED);
    }


    /**
     * @Route("/stats-tresoreries", methods={"GET"})
     *
     * public function extractStatsTersorerie()
     * {
     *    $repositorie = $this->getDoctrine()->getRepository(RtlqTresorie::class);
     *   $results = [];
     *  $kpis = $repositorie->getAllKpis();
     *  foreach ($kpis as $kpi) {
     *     $number = $repositorie->countByKpi($kpi);    
     *    $results[$kpi] = $number;
     *  }
     *  return  $this->newResponse($results, Response::HTTP_ACCEPTED);
     *  }
     */

    /**
     * @Route("/{action}", methods={"GET"})
     */
    public function extractKpi($action)
    {

        if (strpos($action, TresorieRepository::PATTERN_KPI) === 0) {
            $repositorie = $this->getDoctrine()->getRepository(RtlqTresorie::class);
        } else if (strpos($action, AdherentRepository::PATTERN_KPI) === 0) {
            $repositorie = $this->getDoctrine()->getRepository(RtlqAdherent::class);
        } else {
            $repositorieCours = $this->getDoctrine()->getRepository(RtlqKungfuCours::class);
            $statsCours = $repositorieCours->extractStats();
    
            $repositorieAdherents = $this->getDoctrine()->getRepository(RtlqAdherent::class);
            $statsAdherents = $repositorieAdherents->extractStats();

            $repositorieTresoreries = $this->getDoctrine()->getRepository(RtlqTresorie::class);
            $statsTresoreries = $repositorieTresoreries->extractStats();

            
             $results = [
                 'cours' => $statsCours, 
                 "users" => $statsAdherents,
                 'tresorerie' => $statsTresoreries
                ];
            return  $this->newResponse($results, Response::HTTP_ACCEPTED);
    
        }

        $number = $repositorie->countByKpi($action);
        $results = ['description' => $action, 'nombre' => $number];

        return  $this->newResponse($results, Response::HTTP_ACCEPTED);
    }

}
