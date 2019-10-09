<?php

namespace App\Controller\Api\Association;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Association\RtlqBenevolatBuilder;
use App\Form\Dto\Association\RtlqBenevolatDTO;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association\RtlqBenevolat;
use App\Form\Type\Association\RtlqBenevolatType;

/**
 * @Route("/association/benevolats")
 */
class BenevolatController extends AbstractCrudApiController
{
    function newTypeClass(): string {return RtlqBenevolatType::class;}
    function newDtoClass(): string {return RtlqBenevolatDTO::class;}
    function newBuilderClass(): string {return RtlqBenevolatBuilder::class;}
    function newModeleClass(): string {return RtlqBenevolat::class;}


    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['dateCreation' => 'DESC'];
    }
}

