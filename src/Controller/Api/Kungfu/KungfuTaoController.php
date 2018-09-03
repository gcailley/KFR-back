<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;

/**
 * @Route("/kungfu/taos")
 */
class KungfuTaoController extends AbstractCrudApiController
{

    function getName()
    {
        return 'App:Kungfu\RtlqKungfuTao';
    }

    function getNameType()
    {
        return "App\Form\Type\Kungfu\RtlqKungfuTaoType";
    }

    protected function getBuilder()
    {
        return new RtlqKungfuTaoBuilder();
    }

    function newDto()
    {
        return new RtlqKungfuTaoDTO();
    }
}
