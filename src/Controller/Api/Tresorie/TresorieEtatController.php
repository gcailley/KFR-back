<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Tresorie\RtlqTresorieEtatBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieEtatDTO;

/**
 * @Route("/tresorie/etats")
 */
class TresorieEtatController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Tresorie\RtlqTresorieEtat';
    }

    function getNameType()
    {
        return "App\Form\Type\Tresorie\RtlqTresorieEtatType";
    }

    protected function getBuilder()
    {
        return new RtlqTresorieEtatBuilder();
    }
    
    function newDto()
    {
        return new RtlqTresorieEtatDTO();
    }
}
