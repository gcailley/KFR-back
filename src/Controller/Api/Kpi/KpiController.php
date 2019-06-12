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
/*
[
    {"saison_name":"Saison 2014-2015","etat_name":"Encaisse","pointe":false,"montant":"6158.3499999999985"},
    {"saison_name":"Saison 2014-2015","etat_name":"A reclamer","pointe":false,"montant":"35"},
    {"saison_name":"Saison 2014-2015","etat_name":"Regle","pointe":false,"montant":"-2260.85"},
    {"saison_name":"Saison 2015-2016","etat_name":"A encaisser","pointe":false,"montant":"250"},
    {"saison_name":"Saison 2015-2016","etat_name":"Encaisse","pointe":false,"montant":"4594.89"},
    {"saison_name":"Saison 2015-2016","etat_name":"A reclamer","pointe":false,"montant":"250"},
    {"saison_name":"Saison 2015-2016","etat_name":"Regle","pointe":false,"montant":"-4427.799999999999"},
    {"saison_name":"Saison 2016-2017","etat_name":"Encaisse","pointe":false,"montant":"6484.95"},
    {"saison_name":"Saison 2016-2017","etat_name":"A reclamer","pointe":false,"montant":"250"},{"saison_name":"Saison 2016-2017","etat_name":"Regle","pointe":false,"montant":"-4779.580000000001"},{"saison_name":"Saison 2016-2017","etat_name":"Annulee","pointe":false,"montant":"735"},{"saison_name":"Saison 2017-2018","etat_name":"A encaisser","pointe":false,"montant":"418.5"},{"saison_name":"Saison 2017-2018","etat_name":"Encaisse","pointe":false,"montant":"7065.499999999998"},{"saison_name":"Saison 2017-2018","etat_name":"A reclamer","pointe":false,"montant":"487.28"},{"saison_name":"Saison 2017-2018","etat_name":"A regler","pointe":false,"montant":"-1122"},{"saison_name":"Saison 2017-2018","etat_name":"Regle","pointe":false,"montant":"-4816.5"},{"saison_name":"Saison 2017-2018","etat_name":"Annulee","pointe":false,"montant":"394.5"},{"saison_name":"Saison 2018-2019","etat_name":"A encaisser","pointe":false,"montant":"689"},{"saison_name":"Saison 2018-2019","etat_name":"Encaisse","pointe":false,"montant":"435"},{"saison_name":"Saison 2018-2019","etat_name":"Encaisse","pointe":true,"montant":"80"},{"saison_name":"Saison 2018-2019","etat_name":"A reclamer","pointe":false,"montant":"686.4699999999999"},{"saison_name":"Saison 2018-2019","etat_name":"A regler","pointe":false,"montant":"336"},{"saison_name":"Saison 2018-2019","etat_name":"Regle","pointe":false,"montant":"120"},{"saison_name":"Saison 2018-2019","etat_name":"Annulee","pointe":false,"montant":"-2"}]
*/

/* TODO convertir en bean par saison

    $data = [];
    foreach ($results as $result) {
        if (! $data[$result['saison_name']]) {
             $kpiSaison  = new RtlqKpiTresorerieDTO();
             $data[$result['saison_name']] = $kpiSaison;
        }
    }
*/

        return  new Response(json_encode($results), Response::HTTP_ACCEPTED);
    }



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
