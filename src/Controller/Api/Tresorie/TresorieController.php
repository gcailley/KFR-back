<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\json_encode;

use App\Controller\Api\AbstractApiController;
use App\Form\Builder\Tresorie\RtlqTresorieBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieDTO;
use App\Controller\Api\AbstractCrudApiController;
use App\Repository\Tresorie\TresorieRepository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/tresorie/tresories")
 */
class TresorieController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Tresorie\RtlqTresorie';
    }

    function getNameType()
    {
        return "App\Form\Type\Tresorie\RtlqTresorieType";
    }

    protected function getBuilder()
    {
        return new RtlqTresorieBuilder();
    }
    
    function newDto()
    {
        return new RtlqTresorieDTO();
    }

        
     /**
     * @Route("/by-user-{id}", methods={"GET"})
     */
    public function getTresoriesByUser($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $tresorieRepo = $em->getRepository("App\Entity\Tresorie\RtlqTresorie");
        $entity = $tresorieRepo->findAllTresorieFilterByAdherent($id);
        
        if ($entity == null) {
            throw new NotFoundHttpException("No tresorie Found for $id");
        }
        
        $dtos = $this->builder->modelesToDtos($entity);
        return new Response(json_encode($dtos), 201);
    }
}
