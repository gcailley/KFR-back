<?php

namespace App\Controller\Api\Kpi;

use App\Controller\Api\AbstractRtlqController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\json_encode;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Association\RtlqAdherent;
use App\Repository\Tresorie\TresorieRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repository\Association\AdherentRepository;

/**
 * @Route("/kpis")
 */
class KpiController extends AbstractRtlqController
{
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
            throw new HttpException(Response::HTTP_BAD_REQUEST, "No KPI '$action' found.");
        }

        $number = $repositorie->countByKpi($action);
        $results = ['description' => $action, 'nombre' => $number];

        return  new Response(json_encode($results), Response::HTTP_ACCEPTED);
    }
}
