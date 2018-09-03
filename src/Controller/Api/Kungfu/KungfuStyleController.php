<?php

namespace App\Controller\Api\Kungfu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Form\Builder\Kungfu\RtlqKungfuStyleBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuStyleDTO;
use App\Controller\Api\AbstractCrudApiController;

/**
 * @Route("/kungfu/styles")
 */
class KungfuStyleController extends AbstractCrudApiController
{
    
    public function getName()
    {
        return 'App:Kungfu\RtlqKungfuStyle';
    }

    public function getNameType()
    {
        return "App\Form\Type\Kungfu\RtlqKungfuStyleType";
    }

    protected function getBuilder()
    {
        return new RtlqKungfuStyleBuilder();
    }
    
    public function newDto()
    {
        return new RtlqKungfuStyleDTO();
    }
}
