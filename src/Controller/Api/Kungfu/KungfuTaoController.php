<?php

namespace App\Controller\Api\Kungfu;

use App\Controller\Api\AbstractCrudApiController;
use App\Entity\Kungfu\RtlqKungfuTao;
use App\Form\Builder\Kungfu\RtlqKungfuTaoBuilder;
use App\Form\Builder\Kungfu\RtlqKungfuTaoProfBuilder;
use App\Form\Builder\Kungfu\RtlqKungfuTaoReferentBuilder;
use App\Form\Dto\Kungfu\RtlqKungfuTaoDTO;
use App\Form\Dto\Kungfu\RtlqKungfuTaoProfDTO;
use App\Form\Type\Kungfu\RtlqKungfuTaoReferentType;
use App\Form\Type\Kungfu\RtlqKungfuTaoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/kungfu/taos")
 */
class KungfuTaoController extends AbstractCrudApiController
{

    private $limitedTaoBuilder;
    private $referentTaoBuilder;

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
     * Trie utilisé dans la requete getAllAction.
     * exemple : ['username' => 'ASC'].
     */
    public function defaultSort()
    {
        return ['style' => 'ASC', 'niveau' => 'ASC', 'nom' => 'ASC'];
    }


    /**
     * @Route("/{id}", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getByIdAction(Request $request, $id)
    {

        $entity = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);

        if (!is_object($entity)) {
            throw $this->createNotFoundException();
        }

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            $dto_entity = $this->getLimitedTaoBuilder()->modeleToDto($entity, RtlqKungfuTaoDTO::class, $this->getDoctrine());
        } else {
            $dto_entity = $this->getBuilder()->modeleToDto($entity, $this->newDtoClass());
        }
        return  $this->newResponse($dto_entity, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function patchByIdAction(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        //looking for object into the database.
        $entityDB = $this->getDoctrine()->getRepository($this->newModeleClass())->find($id);
        if (!is_object($entityDB)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $entityDto = new RtlqKungfuTao();
        $form = $this->createForm(RtlqKungfuTaoReferentType::class, $entityDto);
        $form->submit($data);

        //validation de l'object DTO
        $errors = $this->getValidator()->doPutValidateDto($entityDto, $em);
        if ($errors != null && sizeof($errors) != 0) {
            throw $this->createInvalideBean($errors);
        }

        // convertion to Modele
        $referentBuilder =
            $entityMetier = $this->getReferentTaoBuilder()->dtoToModele($em, $entityDto, $entityDB);
        $em->merge($entityMetier);
        $em->flush();

        $dto_entity = $this->getReferentTaoBuilder()->modeleToDto($entityMetier, RtlqKungfuTaoDTO::class, $this->getDoctrine());
        return  $this->newResponse($dto_entity, Response::HTTP_ACCEPTED);
    }



    /**
     * @Route("", methods={"GET"})
     */
    public function getAllAction(Request $request, $response = true, $filtre = [])
    {
        $entities = $this->getDoctrine()->getRepository($this->newModeleClass())->findBy($filtre, $this->defaultSort());

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_PROF')) {
            $dto_entities = $this->getLimitedTaoBuilder()->modelesToDtos($entities,  RtlqKungfuTaoDTO::class, $this->getDoctrine());
        } else {
            $dto_entities = $this->getBuilder()->modelesToDtos($entities,  $this->newDtoClass(), $this->getDoctrine());

            // get user token
            $tokenAuth  = $this->getTokenAuth($request);
            $dto_entities = $this->getBuilder()->updateReferent($dto_entities,  $tokenAuth->getUser());
        }


        return $this->convertDto2Response($dto_entities, $response, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/actif", methods={"GET"})
     */
    public function getActifAction(Request $request)
    {
        return $this->getAllAction($request, true, array("actif" => true));
    }


    private function getLimitedTaoBuilder()
    {
        if (null == $this->limitedTaoBuilder) {
            $this->limitedTaoBuilder = new RtlqKungfuTaoBuilder();
        }
        return $this->limitedTaoBuilder;
    }


    private function getReferentTaoBuilder()
    {
        if (null == $this->referentTaoBuilder) {
            $this->referentTaoBuilder = new RtlqKungfuTaoReferentBuilder();
        }
        return $this->referentTaoBuilder;
    }





    //////////////////////////////////////////////////////////////////////

}
