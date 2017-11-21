<?php

namespace RoutanglangquanBundle\Controller\Api\Kungfu;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/api/kungfu/taos")
 */
class KungfuTaoController extends AbstractCrudApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Kungfu\RtlqKungfuTao';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Kungfu\RtlqKungfuTaoType";
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
