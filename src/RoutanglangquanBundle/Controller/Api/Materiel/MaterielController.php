<?php

namespace RoutanglangquanBundle\Controller\Api\Materiel;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Materiel\RtlqMaterielBuilder;
use RoutanglangquanBundle\Form\Dto\Materiel\RtlqMaterielDTO;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;


/**
 * @Route("/materiels")
 */
class MaterielController extends AbstractCrudApiController
{

    function getName()
    {
        return 'RoutanglangquanBundle:Materiel\RtlqMateriel';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Materiel\RtlqMaterielType";
    }

    protected function getBuilder()
    {
        return new RtlqMaterielBuilder();
    }

    function newDto()
    {
        return new RtlqMaterielDTO();
    }

    /**
     * @Route("")
     * @Method("GET")
     */
    public function getAllAction(Request $request, $response= true)
    {
        if ($request->query->get('association') === null) {
            return parent::getAllAction($request);
        } else {
            $association = $request->query->get('association')=="true";

            $entities = $this->getDoctrine()
                    ->getRepository($this->getName())
                    ->findBy(array("association"=>$association));

            $this->returnNewResponse($entities, Response::HTTP_ACCEPTED);
        }
    }

}
