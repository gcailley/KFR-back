<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use App\Form\Builder\Kungfu\RtlqKungfuTaoProfBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Form\Dto\Kungfu\RtlqKungfuTaoProfDTO;
use App\Form\Type\Kungfu\RtlqKungfuTaoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Annotation\Method;

/**
 * @Route("/kungfu/taos")
 */
class KungfuTaoController extends AbstractCrudApiController
{

    private $limitedTaoBuilder;

    function newTypeClass(): string
    {
        return RtlqKungfuTaoType::class;
    }
    function newDtoClass(): string
    {
        return RtlqKungfuTaoProfDTO::class;
    }
    function newBuilderClass(): string
    {
        return RtlqKungfuTaoProfBuilder::class;
    }
    function newModeleClass(): string
    {
        return RtlqKungfuTao::class;
    }


    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getByIdAction(Request $request, $id)
    {

        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);

        if (!is_object($entity)) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            $dto_entity = $this->getLimitedTaoBuilder()->modeleToDto($entity, RtlqKungfuTaoDTO::class);
        } else {
            $dto_entity = $this->getBuilder()->modeleToDto($entity, $this->newDtoClass());
        }
        return  $this->newResponse($dto_entity, Response::HTTP_ACCEPTED);
    }



    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response = true)
    {
        $entities = $this->getDoctrine()->getRepository($this->newModeleClass())->findBy([], $this->defaultSort());

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            $dto_entities = $this->getLimitedTaoBuilder()->modelesToDtos($entities,  RtlqKungfuTaoDTO::class);
        } else {
            $dto_entities = $this->getBuilder()->modelesToDtos($entities,  $this->newDtoClass());
        }

        return $this->convertDto2Response($dto_entities, $response, Response::HTTP_ACCEPTED);
    }

    private function getLimitedTaoBuilder()
    {
        if (null == $this->limitedTaoBuilder) {
            $this->limitedTaoBuilder = new RtlqKungfuTaoBuilder();
        } 
        return $this->limitedTaoBuilder;
        
    }

}
