<?php

namespace App\Controller\Api\Tresorie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Tresorie\RtlqTresorieEtatBuilder;
use App\Form\Dto\Tresorie\RtlqTresorieEtatDTO;
use App\Form\Type\Tresorie\RtlqTresorieEtatType;
use Proxies\__CG__\App\Entity\Tresorie\RtlqTresorieEtat;

/**
 * @Route("/tresorie/etats")
 */
class TresorieEtatController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqTresorieEtatType::class;}
    function newDtoClass(): string {return RtlqTresorieEtatDTO::class;}
    function newBuilderClass(): string {return RtlqTresorieEtatBuilder::class;}
    function newModeleClass(): string {return RtlqTresorieEtat::class;}
}
