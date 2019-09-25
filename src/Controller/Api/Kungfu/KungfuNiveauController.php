<?php

namespace App\Controller\Api\Kungfu;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;
use GuzzleHttp\json_encode;

use App\Form\Builder\Kungfu\RtlqKungfuNiveauBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuNiveauDTO;
use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Kungfu\RtlqKungfuNiveau;
use App\Form\Type\Kungfu\RtlqKungfuNiveauType;

/**
 * @Route("/kungfu/niveaux")
 */
class KungfuNiveauController extends AbstractCrudApiController
{
    
    function newTypeClass(): string {return RtlqKungfuNiveauType::class;}
    function newDtoClass(): string {return RtlqKungfuNiveauDTO::class;}
    function newBuilderClass(): string {return RtlqKungfuNiveauBuilder::class;}
    function newModeleClass(): string {return RtlqKungfuNiveau::class;}

}
