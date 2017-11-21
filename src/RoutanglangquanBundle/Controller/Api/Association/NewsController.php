<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqNewsBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqNewsDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/api/association/news")
 */
class NewsController extends AbstractCrudApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Association\RtlqNews';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqNewsType";
    }

    protected function getBuilder()
    {
        return new RtlqNewsBuilder();
    }

    function newDto()
    {
        return new RtlqNewsDTO();
    }
}
