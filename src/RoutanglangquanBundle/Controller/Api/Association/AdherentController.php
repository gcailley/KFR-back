<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use Symfony\Component\HttpFoundation\Request;
use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Form\Validator\Association\RtlqAdherentValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use RoutanglangquanBundle\Service\Security\User\AuthTokenAuthenticator;
use function GuzzleHttp\json_encode;

/**
 * @Route("/api/association/adherents")
 */
class AdherentController extends AbstractCrudApiController {


    function getName() {
        return 'RoutanglangquanBundle:Association\RtlqAdherent';
    }

    function getNameType() {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqAdherentType";
    }

    protected function getBuilder() {
        return new RtlqAdherentBuilder();
    }

    function newDto() {
        return new RtlqAdherentDTO();
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator() {
        return new RtlqAdherentValidator();
    }
    
    /**
     * Cas spécifique de détachement des tresories. 
     */
    protected function internalDeleteByIdAction($em, $entity) {
        $entity->removeAllTresories();
        $entity->removeCotisation();
        $entity->removeAllGroupes();
    }

    // ********************************* COTISATION **********************************************//

    /**
     * @Route("/{id}/cotisation")
     * @Method("GET")
     */
    public function getUserCotisation($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getCotisationId()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/cotisation/{idCotisation}")
     * @Method("POST")
     */
    public function addCotisationToUser($id, $idCotisation) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $cotisation = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation")->find($idCotisation);
        if (!is_object($cotisation)) {
            throw new NotFoundHttpException("Cotisation $idCotisation not found");
        }
        //add cotisation to adherent
        $entity->setCotisation($cotisation);

        $em = $this->getDoctrine()->getManager();
        $em->merge($entity);
        $em->flush();

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/cotisation/{idCotisation}")
     * @Method("DELETE")
     */
    public function removeCotisationToUser($id, $idCotisation) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $cotisation = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Cotisation\RtlqCotisation")->find($idCotisation);
        if (!is_object($cotisation)) {
            throw new NotFoundHttpException("Cotisation $idCotisation not found");
        }
        if ($this->getValidator()->hasCotisation($entity, $cotisation)) {
            //add cotisation to adherent
            $entity->setCotisation(null);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    // ********************************* GROUPE **********************************************//

    /**
     * @Route("/{id}/groupes")
     * @Method("GET")
     */
    public function getUserGroupes($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getGroupes()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/groupes/{idGroupe}")
     * @Method("POST")
     */
    public function addGroupeToUser($id, $idGroupe) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $groupe = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Association\RtlqGroupe")->find($idGroupe);
        if (!is_object($groupe)) {
            throw new NotFoundHttpException("Groupe $idGroupe not found");
        }

        if (!$this->getValidator()->hasGroupe($entity, $groupe)) {
            //add groupe to adherent
            $entity->addGroupe($groupe);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }
        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/groupes/{idGroupe}")
     * @Method("DELETE")
     */
    public function removeGroupeToUser($id, $idGroupe) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Association\RtlqGroupe")->find($idGroupe);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Groupe $idGroupe not found");
        }
        if ($this->getValidator()->hasGroupe($entity, $entityAssociate)) {
            //add cotisation to adherent
            $entity->removeGroupe($entityAssociate);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    // ********************************* TRESORIE **********************************************//
    /**
     * @Route("/{id}/tresories")
     * @Method("GET")
     */
    public function getUserTresories($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity, $this);
        return new Response(json_encode($dto->getTresories()), Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}")
     * @Method("POST")
     */
    public function addTresorieToUser($id, $idEntityAssociate) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie")->find($idEntityAssociate);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Tresorie $idEntityAssociate not found");
        }

        if (!$this->getValidator()->hasTresorie($entity, $entityAssociate)) {
            //add tresorie to adherent
            $entity->addTresorie($entityAssociate);
            $entityAssociate->setAdherent($entity);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->merge($entityAssociate);
            $em->flush();

        }

        return $this->newResponse(json_encode($entity), Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}")
     * @Method("DELETE")
     */
    public function removeTresorieToUser($id, $idEntityAssociate) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }
        $entityAssociate = $this->getDoctrine()->getRepository("RoutanglangquanBundle\Entity\Tresorie\RtlqTresorie")->find($idEntityAssociate);
        if (!is_object($entityAssociate)) {
            throw new NotFoundHttpException("Tresorie $idEntityAssociate not found");
        }
        if ($this->getValidator()->hasTresorie($entity, $entityAssociate)) {
            //add cotisation to adherent
            $entity->removeTresorie($entityAssociate);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, Response::HTTP_NO_CONTENT);
    }


    /**
     * @Route("/by-token")
     * @Method("GET")
     */
    public function getUserByToken(Request $request) {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        $entityAssociate = $this->getDoctrine()
                ->getRepository("RoutanglangquanBundle\Entity\Security\RtlqAuthToken")
                    ->findOneBy(array("value"=>$authTokenHeader));
        if (!is_object($entityAssociate)) {
            throw new createAccessDeniedException();
        }
        //get user information based on the id associate from the token
        return $this->getByIdAction($entityAssociate->getUser()->getId());
    }
}
