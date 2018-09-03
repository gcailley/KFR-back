<?php

namespace App\Controller\Api\Kungfu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Form\Builder\Kungfu\RtlqKungfuNiveauBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuNiveauDTO;
use App\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/kungfu/niveaux")
 */
class KungfuNiveauController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'App:Kungfu\RtlqKungfuNiveau';
    }

    function getNameType()
    {
        return "App\Form\Type\Kungfu\RtlqKungfuNiveauType";
    }

    protected function getBuilder()
    {
        return new RtlqKungfuNiveauBuilder();
    }
    
    function newDto()
    {
        return new RtlqKungfuNiveauDTO();
    }
}
