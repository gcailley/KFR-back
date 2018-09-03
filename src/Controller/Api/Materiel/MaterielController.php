<?php

namespace App\Controller\Api\Materiel;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Materiel\RtlqMaterielBuilder;
use App\Form\Dto\Materiel\RtlqMaterielDTO;
use Symfony\Component\Routing\Annotation\Route;
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
        return 'App:Materiel\RtlqMateriel';
    }

    function getNameType()
    {
        return "App\Form\Type\Materiel\RtlqMaterielType";
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
     * @Route("", methods={"GET"})
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
