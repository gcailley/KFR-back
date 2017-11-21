<?php

namespace RoutanglangquanBundle\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Controller\Api\AbstractApiController;
use RoutanglangquanBundle\Form\Builder\Tresorie\RtlqTresorieCategorieBuilder;
use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieCategorieDTO;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/api/tresorie/categories")
 */
class TresorieCategorieController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'RoutanglangquanBundle:Tresorie\RtlqTresorieCategorie';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Tresorie\RtlqTresorieCategorieType";
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
