<?php

namespace App\Controller\Api\Association;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqPhotoDirectoryBuilder;
use App\Form\Dto\Association\RtlqPhotoDirectoryDTO;
use App\Controller\Api\AbstractApiController;

/**
 * @Route("/association/photo_directories")
 */
class PhotoDirectoryController extends AbstractCrudApiController
{

    function getName()
    {
        return 'App:Association\RtlqPhotoDirectory';
    }

    function getNameType()
    {
        return "App\Form\Type\Association\RtlqPhotoDirectoryType";
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
