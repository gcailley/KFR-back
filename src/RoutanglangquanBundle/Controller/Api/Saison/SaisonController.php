<?php

namespace RoutanglangquanBundle\Controller\Api\Saison;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Saison\RtlqSaisonBuilder;
use RoutanglangquanBundle\Form\Dto\Saison\RtlqSaisonDTO;
use RoutanglangquanBundle\Form\Validator\Saison\RtlqSaisonValidator;
use RoutanglangquanBundle\Repository\Saison\SaisonRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/saisons")
 */
class SaisonController extends AbstractCrudApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Saison\RtlqSaison';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Saison\RtlqSaisonType";
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
     * @Route("/active")
     * @Method("GET")
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
