<?php

namespace App\Controller\Api\Saison;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;


use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Saison\RtlqCategorieVoteeBuilder;
use App\Form\Dto\Saison\RtlqCategorieVoteeDTO;
use Proxies\__CG__\App\Entity\Tresorie\RtlqTresorieCategorie;

/**
 * @Route("/categorievotees")
 */
class CategorieVoteeController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Saison\RtlqCategorieVotee';
    }

    function getNameType()
    {
        return "App\Form\Type\Saison\RtlqCategorieVoteeType";
    }

    protected function getBuilder()
    {
        return new RtlqCategorieVoteeBuilder();
    }
    
    function newDto()
    {
        return new RtlqCategorieVoteeDTO();
    }

 /**
     * @Route("/saisons/{idSaison}", methods={"POST"})
     */
    public function generateCategorieVoteeBySaison(Request $request, $idSaison)
    {
        // récupération des categories votee de la saison
        $listOfCategorieVotee = $this->getDoctrine()->getRepository($this->getName())->findBy(
            array("saison"=>$idSaison), null);

        // extract ids categorie
        $listOfCategorieVoteeId = [];
        foreach ($listOfCategorieVotee as $key => $categorieVoteeValue) {
            $listOfCategorieVoteeId[] = $categorieVoteeValue->getCategorieId();
        }

        // récupération de la liste des categories en base
        $em = $this->getDoctrine()->getManager();
        $listOfCategorie = $this->getDoctrine()->getRepository(RtlqTresorieCategorie::class)->findAll();
        foreach ($listOfCategorie as $key => $categorieValue) {
            $listOfCategorieId[] = $categorieValue->getId();
        }


        $listOfCategorieIdMissing = array_diff($listOfCategorieId, $listOfCategorieVoteeId);
        $listOfEntity = [];
        foreach ($listOfCategorieIdMissing as $categorieIdMissing) {
            //search this categorie in listOfCategorieId
            $dto = $this->newDto();
            $dto->setCategorieId($categorieIdMissing);
            $dto->setMontant(0);
            $dto->setSaisonId($idSaison);

            $entityMetier = $this->getNewModeleInstance();
            $this->builder->dtoToModele($em, $dto, $entityMetier, $this);
            $entityMetier->setId(null);
            $em->persist($entityMetier);
            $listOfEntity[] = $entityMetier;

            $em->flush();
        }

        return $this->returnNewResponse($listOfEntity, Response::HTTP_NO_CONTENT);

    }



       /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['saison' => 'DESC'];
    }
}
