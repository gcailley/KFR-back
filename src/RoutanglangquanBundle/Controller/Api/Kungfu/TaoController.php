<?php

namespace RoutanglangquanBundle\Controller\Api\Kungfu;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Kungfu\RtlqTaoBuilder;
use RoutanglangquanBundle\Form\Dto\Kungfu\RtlqTaoDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/api/kungfu/taos")
 */
class TaoController extends AbstractCrudApiController {

    protected function getName() {
        return 'RoutanglangquanBundle:Kungfu\RtlqTao';
    }

    protected function getNameType() {
        return "RoutanglangquanBundle\Form\Type\Kungfu\RtlqTaoType";
    }

    protected function getBuilder() {
        return new RtlqTaoBuilder();
    }

    protected function newDto() {
        return new RtlqTaoDTO();
    }

}
