<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractRtlqController;
use App\Entity\Saison\RtlqCategorieVotee;
use App\Entity\Tresorie\RtlqTresorie;
use App\Entity\Tresorie\RtlqTresorieCategorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/association/dashboard")
 */
class DashboardController extends AbstractRtlqController {
    /**
     * @Route("/tresorerie-by-categorie/{idSaison}", methods={"GET"})
     */
    public function getTresorerieByCategorie(Request $request, $idSaison)
    {

        // on recupérer toutes les categorieVotee pour une saison
        $listOfCategorieVotees = $this->getDoctrine()->getRepository(RtlqCategorieVotee::class)->findBy(
            array("saison"=>$idSaison), null);

        // on recuperer la somme des montants dépensés par categorie pour la saison
        $tresorieRepo = $this->getDoctrine()->getRepository(RtlqTresorie::class);
        $listOfDepenses = $tresorieRepo->extractMontantsDepenseParCategories($idSaison);

        // on recuperer les catégories disponibles
        $listOfCategories = $this->getDoctrine()->getRepository(RtlqTresorieCategorie::class)->findAll();
        
        $dataLabels = [];
        $dataExpected = [];
        $dataReal = [];

        foreach ($listOfCategories as $key => $value) {
            $idCategory = $value->getId();
            //chercher dans la liste des dépenses
            $valueReal = 0;
            foreach($listOfDepenses as $keyDepense => $valueDepense) {
                if ($valueDepense['categorie_id'] == $idCategory ) {
                    $valueReal = $valueDepense['montant'];
                    break;
                }
            }

            //chercher dans la liste des objecifs
            $valueExpected = 0;
            foreach($listOfCategorieVotees as $keyCategorieVotee => $valueCategorieVotee) {
                if ($valueCategorieVotee->getCategorieId() == $idCategory ) {
                    $valueExpected = $valueCategorieVotee->getMontant();
                    break;
                }
            }
            if (0 != $valueExpected || 0 != $valueReal ) {
                $dataReal[] = $valueReal;
                $dataExpected[] = $valueExpected;
                $dataLabels[] = $value->getValue();
            }

        }
        // on faite le regroupement
        $dto_tresorie = [];

        $dto_tresorie['labels'] = $dataLabels;
        $dto_tresorie['data_expected'] = $dataExpected;
        $dto_tresorie['data_real'] = $dataReal;

        return  $this->newResponse(json_encode($dto_tresorie), Response::HTTP_ACCEPTED);
    }

    
    /**
     * @Route("/tresorerie-by-saison", methods={"GET"})
     */
    public function getTresorerieBySaisons(Request $request)
    {

        // on recuperer la somme des montants dépensés par categorie pour la saison
        $tresorieRepo = $this->getDoctrine()->getRepository(RtlqTresorie::class);
        $listOfDepenses = $tresorieRepo->extractMontantsDepenseParSaisons();
       
        $dataLabels = [];
        $dataReal = [];

        foreach ($listOfDepenses as $key => $value) {
            $dataReal[] = $value['montant'];
            $dataLabels[] = $value['saison_name'];

        }
        // on faite le regroupement
        $dto_tresorie = [];

        $dto_tresorie['labels'] = $dataLabels;
        $dto_tresorie['data_real'] = $dataReal;

        return  $this->newResponse(json_encode($dto_tresorie), Response::HTTP_ACCEPTED);
    }

     /**
     * @Route("/tresorerie-by-saison/{idSaison}", methods={"GET"})
     */
    public function getTresorerieBySaison(Request $request, $idSaison)
    {

        // on recuperer la somme des montants dépensés par categorie pour la saison
        $tresorieRepo = $this->getDoctrine()->getRepository(RtlqTresorie::class);
        $listOfDepenses = $tresorieRepo->extractMontantsDepenseParSaison($idSaison);
       
        $dataLabels = [];
        $dataReal = [];

        foreach ($listOfDepenses as $key => $value) {
            $dataReal[] = $value['montant'];
            $dataLabels[] = $this->dateToString($value['month']);

        }
        // on faite le regroupement
        $dto_tresorie = [];

        $dto_tresorie['labels'] = $dataLabels;
        $dto_tresorie['data_real'] = $dataReal;

        return  $this->newResponse(json_encode($dto_tresorie), Response::HTTP_ACCEPTED);
    }

    protected function  dateToString($date) {
        
    	return $date==null ? null : $date->format('Y-m-d');
    }
    
}
