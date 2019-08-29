<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Kungfu\RtlqKungfuCoursBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuCoursDTO;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kungfu/cours")
 */
class KungfuCoursController extends AbstractCrudApiController
{

    function getName()
    {
        return 'App:Kungfu\RtlqKungfuCours';
    }

    function getNameType()
    {
        return "App\Form\Type\Kungfu\RtlqKungfuCoursType";
    }

    protected function getBuilder()
    {
        return new RtlqKungfuCoursBuilder();
    }

    function newDto()
    {
        return new RtlqKungfuCoursDTO();
    }
}
