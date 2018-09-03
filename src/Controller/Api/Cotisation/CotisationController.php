<?php

namespace App\Controller\Api\Cotisation;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Cotisation\RtlqCotisationBuilder;
use App\Form\Dto\Cotisation\RtlqCotisationDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cotisation\RtlqCotisation;



/**
 * @Route("/cotisations")
 */
class CotisationController extends AbstractCrudApiController
{
   
    function getName()
    {
        return RtlqCotisation::class;
    }

    function getNameType()
    {
        return "App\Form\Type\Cotisation\RtlqCotisationType";
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
     * @Route("/active", methods={"GET"})
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
