<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Form\Type\Kungfu\RtlqKungfuTaoType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;

/**
 * @Route("/kungfu/taos")
 */
class KungfuTaoController extends AbstractCrudApiController
{

    function newTypeClass(): string {return RtlqKungfuTaoType::class;}
    function newDtoClass(): string {return RtlqKungfuTaoDTO::class;}
    function newBuilderClass(): string {return RtlqKungfuTaoBuilder::class;}
    function newModeleClass(): string {return RtlqKungfuTao::class;}

}
