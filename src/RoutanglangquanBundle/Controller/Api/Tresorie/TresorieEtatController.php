<?php

namespace RoutanglangquanBundle\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\json_encode;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Tresorie\RtlqTresorieEtatBuilder;
use RoutanglangquanBundle\Form\Dto\Tresorie\RtlqTresorieEtatDTO;

/**
 * @Route("/api/tresorie/etats")
 */
class TresorieEtatController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'RoutanglangquanBundle:Tresorie\RtlqTresorieEtat';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Tresorie\RtlqTresorieEtatType";
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
