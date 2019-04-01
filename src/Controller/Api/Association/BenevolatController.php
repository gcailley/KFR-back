<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqBenevolatBuilder;
use App\Form\Dto\Association\RtlqBenevolatDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association\RtlqBenevolat;



/**
 * @Route("/association/benevolats")
 */
class BenevolatController extends AbstractCrudApiController
{
   
    function getName()
    {
        return RtlqBenevolat::class;
    }

    function getNameType()
    {
        return "App\Form\Type\Association\RtlqBenevolatType";
    }

    protected function getBuilder()
    {
        return new RtlqBenevolatBuilder();
    }
    
    function newDto()
    {
        return new RtlqBenevolatDTO();
    }
}
