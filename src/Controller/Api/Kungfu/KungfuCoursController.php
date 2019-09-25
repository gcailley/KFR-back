<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Kungfu\RtlqKungfuCours;
use App\Form\Builder\Kungfu\RtlqKungfuCoursBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuCoursDTO;
use App\Form\Type\Kungfu\RtlqKungfuCoursType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kungfu/cours")
 */
class KungfuCoursController extends AbstractCrudApiController
{
        
    function newTypeClass(): string {return RtlqKungfuCoursType::class;}
    function newDtoClass(): string {return RtlqKungfuCoursDTO::class;}
    function newBuilderClass(): string {return RtlqKungfuCoursBuilder::class;}
    function newModeleClass(): string {return RtlqKungfuCours::class;}

    /**
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['date' => 'DESC'];
    }

}
