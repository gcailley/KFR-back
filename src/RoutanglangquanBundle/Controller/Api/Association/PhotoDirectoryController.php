<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqPhotoDirectoryBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use RoutanglangquanBundle\Controller\Api\AbstractApiController;

/**
 * @Route("/association/photo_directories")
 */
class PhotoDirectoryController extends AbstractCrudApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Association\RtlqPhotoDirectory';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqPhotoDirectoryType";
    }

    protected function getBuilder()
    {
        return new RtlqPhotoDirectoryBuilder();
    }

    function newDto()
    {
        return new RtlqPhotoDirectoryDTO();
    }
}
