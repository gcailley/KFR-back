<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqNewsBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqNewsDTO;
use RoutanglangquanBundle\Controller\Api\AbstractApiController;

/**
 * @Route("/api/association/photos")
 */
class PhotoController extends AbstractApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Association\RtlqNews';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqNewsType";
    }

    protected function getBuilder()
    {
        return new RtlqNewsBuilder();
    }

    function newDto()
    {
        return new RtlqNewsDTO();
    }


    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    public function getByIdAction($id)
    {
          return  $this->newResponse(json_encode(null), Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request)
    {
          return  $this->newResponse(json_encode(null), Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @Route("")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
          return  $this->newResponse(json_encode(null), Response::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteByIdAction($id)
    {
        return  $this->newResponse(json_encode(null), Response::HTTP_NOT_IMPLEMENTED);
    }
}
