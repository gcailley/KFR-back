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
use App\Entity\Association\RtlqPhotoDirectory;
use App\Form\Type\Association\RtlqPhotoDirectoryType;

/**
 * @Route("/association/photo_directories")
 */
class PhotoDirectoryController extends AbstractCrudApiController
{

    function newTypeClass(): string {return RtlqPhotoDirectoryType::class;}
    function newDtoClass(): string {return RtlqPhotoDirectoryDTO::class;}
    function newBuilderClass(): string {return RtlqPhotoDirectoryBuilder::class;}
    function newModeleClass(): string {return RtlqPhotoDirectory::class;}

}
