<?php

namespace App\Controller\Api\Saison;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;


use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Saison\RtlqCategorieVotee;
use App\Form\Builder\Saison\RtlqCategorieVoteeBuilder;
use App\Form\Dto\Saison\RtlqCategorieVoteeDTO;
use App\Form\Type\Saison\RtlqCategorieVoteeType;
use Proxies\__CG__\App\Entity\Tresorie\RtlqTresorieCategorie;

/**
 * @Route("/categorievotees")
 */
class CategorieVoteeController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqCategorieVoteeType::class;}
    function newDtoClass(): string {return RtlqCategorieVoteeDTO::class;}
    function newBuilderClass(): string {return RtlqCategorieVoteeBuilder::class;}
    function newModeleClass(): string {return RtlqCategorieVotee::class;}


 /**
     * @Route("/saisons/{idSaison}", methods={"POST"})
     */
    public function generateCategorieVoteeBySaison(Request $request, $idSaison)
    {
        // récupération des categories votee de la saison
        $listOfCategorieVotee = $this->getDoctrine()->getRepository($this->newModeleClass())->findBy(
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
            $this->getBuilder()->dtoToModele($em, $dto, $entityMetier, $this->newDtoClass());
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
