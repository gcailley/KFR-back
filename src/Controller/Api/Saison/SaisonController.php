<?php

namespace App\Controller\Api\Saison;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Saison\RtlqSaisonBuilder;
use App\Form\Dto\Saison\RtlqSaisonDTO;
use App\Form\Validator\Saison\RtlqSaisonValidator;
use App\Repository\Saison\SaisonRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/saisons")
 */
class SaisonController extends AbstractCrudApiController
{
    function getName()
    {
        return 'App:Saison\RtlqSaison';
    }

    function getNameType()
    {
        return "App\Form\Type\Saison\RtlqSaisonType";
    }

    protected function getBuilder()
    {
        return new RtlqSaisonBuilder();
    }

    function newDto()
    {
        return new RtlqSaisonDTO();
    }


    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator()
    {
        return new RtlqSaisonValidator();
    }


    public function preConditionCreationAction($em, $entityMetier)
    {
        // uniquement si cette saison et la saison active
        // précondution
        if ($entityMetier->getActive()) {
            //1) desactive toutes les autres saisons
            $saisonsActives = $this->getDoctrine()
                ->getRepository($this->getName())
                ->findBy(array("active"=>true));

            foreach ($saisonsActives as $saisonActive) {
                $saisonActive->setActive(false);
                $em->merge($saisonActive);
            }
            $em->flush();
        }

        return null;
    }

    /**
     * @Route("/active", methods={"GET"})
     */
    public function getActiveAction(Request $request)
    {
       
        $entities = $this->getDoctrine()
            ->getRepository($this->getName())
            ->findBy(array("active"=>true), null, 1 , null);
        //clean user information
        foreach($entities as $entitie) {
            $entitie->removeAllAdherents();
        }
        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }
}
