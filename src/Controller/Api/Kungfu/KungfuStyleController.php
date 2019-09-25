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
use App\Entity\Kungfu\RtlqKungfuStyle;
use App\Form\Type\Kungfu\RtlqKungfuStyleType;

/**
 * @Route("/kungfu/styles")
 */
class KungfuStyleController extends AbstractCrudApiController
{

    function newTypeClass(): string {return RtlqKungfuStyleType::class;}
    function newDtoClass(): string {return RtlqKungfuStyleDTO::class;}
    function newBuilderClass(): string {return RtlqKungfuStyleBuilder::class;}
    function newModeleClass(): string {return RtlqKungfuStyle::class;}

}
