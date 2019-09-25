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
   
    function newTypeClass(): string {return RtlqCotisationType::class;}
    function newDtoClass(): string {return RtlqCotisationDTO::class;}
    function newBuilderClass(): string {return RtlqCotisationBuilder::class;}
    function newModeleClass(): string {return RtlqCotisation::class;}


    /**
     * @Route("/active", methods={"GET"})
     */
    public function getActiveAction(Request $request)
    {
        $entities = $this->getDoctrine()
            ->getRepository($this->newModeleClass())
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
