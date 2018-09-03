<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Controller\Api\AbstractApiController;
use App\Form\Builder\Tresorie\RtlqTresorieCategorieBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieCategorieDTO;
use App\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/tresorie/categories")
 */
class TresorieCategorieController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Tresorie\RtlqTresorieCategorie';
    }

    function getNameType()
    {
        return "App\Form\Type\Tresorie\RtlqTresorieCategorieType";
    }

    protected function getBuilder()
    {
        return new RtlqTresorieCategorieBuilder();
    }
    
    function newDto()
    {
        return new RtlqTresorieCategorieDTO();
    }
}
