<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqEventBuilder;
use App\Form\Dto\Association\RtlqEventDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association\RtlqEvent;



/**
 * @Route("/association/events")
 */
class EventController extends AbstractCrudApiController
{
   
    function getName()
    {
        return RtlqEvent::class;
    }

    function getNameType()
    {
        return "App\Form\Type\Association\RtlqEventType";
    }

    protected function getBuilder()
    {
        return new RtlqEventBuilder();
    }
    
    function newDto()
    {
        return new RtlqEventDTO();
    }
}
