<?php

namespace RoutanglangquanBundle\Controller\Api\Cotisation;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Cotisation\RtlqCotisationBuilder;
use RoutanglangquanBundle\Form\Dto\Cotisation\RtlqCotisationDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api/cotisations")
 */
class CotisationController extends AbstractCrudApiController
{
    
    function getName()
    {
        return 'RoutanglangquanBundle:Cotisation\RtlqCotisation';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Cotisation\RtlqCotisationType";
    }

    protected function getBuilder()
    {
        return new RtlqCotisationBuilder();
    }
    
    function newDto()
    {
        return new RtlqCotisationDTO();
    }
}
