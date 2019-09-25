<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Controller\Api\AbstractApiController;
use App\Form\Builder\Tresorie\RtlqTresorieCategorieBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieCategorieDTO;
use App\Controller\Api\AbstractCrudApiController;
use App\Form\Type\Tresorie\RtlqTresorieCategorieType;
use Proxies\__CG__\App\Entity\Tresorie\RtlqTresorieCategorie;

/**
 * @Route("/tresorie/categories")
 */
class TresorieCategorieController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqTresorieCategorieType::class;}
    function newDtoClass(): string {return RtlqTresorieCategorieDTO::class;}
    function newBuilderClass(): string {return RtlqTresorieCategorieBuilder::class;}
    function newModeleClass(): string {return RtlqTresorieCategorie::class;}

}
