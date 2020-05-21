<?php

namespace App\Controller\Api\Association;

use Symfony\Component\Routing\Annotation\Route;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Association\RtlqBureau;
use App\Form\Builder\Association\RtlqBureauBuilder;
use App\Form\Dto\Association\RtlqBureauDTO;
use App\Form\Type\Association\RtlqBureauType;

/**
 * @Route("/association/bureaux")
 */
class BureauController extends AbstractCrudApiController

{
    function newTypeClass(): string {return RtlqBureauType::class;}
    function newDtoClass(): string {return RtlqBureauDTO::class;}
    function newBuilderClass(): string {return RtlqBureauBuilder::class;}
    function newModeleClass(): string {return RtlqBureau::class;}

    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateCreation' => 'DESC'];
    }

    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllSaisons();
    }

}

