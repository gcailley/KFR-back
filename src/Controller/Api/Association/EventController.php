<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqEventBuilder;
use App\Form\Dto\Association\RtlqEventDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association\RtlqEvent;
use App\Form\Type\Association\RtlqEventType;

/**
 * @Route("/association/events")
 */
class EventController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqEventType::class;}
    function newDtoClass(): string {return RtlqEventDTO::class;}
    function newBuilderClass(): string {return RtlqEventBuilder::class;}
    function newModeleClass(): string {return RtlqEvent::class;}


    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateCreation' => 'DESC'];
    }
}
