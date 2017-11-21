<?php

namespace RoutanglangquanBundle\Controller\Api\Saison;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Saison\RtlqSaisonBuilder;
use RoutanglangquanBundle\Form\Dto\Saison\RtlqSaisonDTO;
use RoutanglangquanBundle\Form\Validator\Saison\RtlqSaisonValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use RoutanglangquanBundle\Repository\Saison\SaisonRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/api/saisons")
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
            $saisonRepo = $em->getRepository("RoutanglangquanBundle\Entity\Saison\RtlqSaison");
            $saisonsActives = $saisonRepo->findAllSeasonFilterByActive(true);
            foreach ($saisonsActives as $saisonActive) {
                $saisonActive->setActive(false);
                $em->merge($saisonActive);
            }
            $em->flush();
        }

        return null;
    }

    /**
     * @Route("", name="active")
     * @Method("GET")
     * Security("has_role('ROLE_ADMIN')")
     */
    public function getAllActiveAction(Request $request)
    {
        $active = $request->query->get('active')=="true";
        
        $em = $this->getDoctrine()->getManager();
        $saisonRepo = $em->getRepository("RoutanglangquanBundle\Entity\Saison\RtlqSaison");
        
        $saisons = $saisonRepo->findAllSeasonFilterByActive($active);
        
        $dto_saisons = $this->builder->modelesToDtos($saisons);
        return new Response(json_encode($dto_saisons), Response::HTTP_ACCEPTED);
    }
}
