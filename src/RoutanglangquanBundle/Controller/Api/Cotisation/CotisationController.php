<?php

namespace RoutanglangquanBundle\Controller\Api\Cotisation;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Cotisation\RtlqCotisationBuilder;
use RoutanglangquanBundle\Form\Dto\Cotisation\RtlqCotisationDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



/**
 * @Route("/cotisations")
 */
class CotisationController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'RoutanglangquanBundle:Cotisation\RtlqCotisation';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Cotisation\RtlqCotisationType";
    }

    protected function getBuilder()
    {
        return new RtlqCotisationBuilder();
    }
    
    function newDto()
    {
        return new RtlqCotisationDTO();
    }
    /**
     * @Route("/active")
     * @Method("GET")
     */
    public function getActiveAction(Request $request)
    {
        $entities = $this->getDoctrine()
            ->getRepository($this->getName())
            ->createQueryBuilder('a')
            ->join('a.saison', 's')
            ->where('a.active = :active')
            ->andWhere('s.active = :saison_active')
            ->setParameter('active', true)
            ->setParameter('saison_active', true)
            ->getQuery()
            ->getResult();
        return $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
    }
}
