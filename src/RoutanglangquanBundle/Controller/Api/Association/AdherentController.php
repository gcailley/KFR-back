<?php

namespace RoutanglangquanBundle\Controller\Api\Association;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Association\RtlqAdherentBuilder;
use RoutanglangquanBundle\Form\Dto\Association\RtlqAdherentDTO;
use RoutanglangquanBundle\Form\Validator\Association\RtlqAdherentValidator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use function GuzzleHttp\json_encode;

/**
 * @Route("/api/association/adherents")
 */
class AdherentController extends AbstractCrudApiController {

    protected function getName() {
        return 'RoutanglangquanBundle:Association\RtlqAdherent';
    }

    protected function getNameType() {
        return "RoutanglangquanBundle\Form\Type\Association\RtlqAdherentType";
    }

    protected function getBuilder() {
        return new RtlqAdherentBuilder();
    }

    protected function newDto() {
        return new RtlqAdherentDTO();
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator() {
        return new RtlqAdherentValidator();
    }

    
    // ********************************* COTISATION **********************************************//
    
    /**
     * @Route("/{id}/cotisations/")
     * @Method("GET")
     */
    public function getUserCotisations($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity);
        return new Response(json_encode($dto->getCotisations()), 201);
    }

    /**
     * @Route("/{id}/cotisations/{idCotisation}")
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
        if ($this->getValidator()->hasNotCotisationSameSeason($entity, $cotisation)) {
            //add cotisation to adherent
            $entity->addCotisation($cotisation);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();

            return new Response(null, 201);
        } else {
            //cas de l'injection du meme id.
            if ($this->getValidator()->hasCotisation($entity, $cotisation)) {
                return new Response(null, 201);
            }
            throw new ConflictHttpException("Cotisation sur la même Saison détectée");
        }
    }

    /**
     * @Route("/{id}/cotisations/{idCotisation}")
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
            $entity->removeCotisation($cotisation);

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }

        return new Response(null, 201);
    }

    // ********************************* GROUPE **********************************************//
    
    /**
     * @Route("/{id}/groupes/")
     * @Method("GET")
     */
    public function getUserGroupes($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity);
        return new Response(json_encode($dto->getGroupes()), 201);
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
        return new Response(null, 201);
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

        return new Response(null, 201);
    }

    // ********************************* TRESORIE **********************************************//
    /**
     * @Route("/{id}/tresories/")
     * @Method("GET")
     */
    public function getUserTresories($id) {
        $entity = $this->getDoctrine()->getRepository($this->getName())->find($id);
        if (!is_object($entity)) {
            throw new NotFoundHttpException("Adherent $id not found");
        }

        $dto = $this->builder->modeleToDto($entity);
        return new Response(json_encode($dto->getTresories()), 201);
    }

    /**
     * @Route("/{id}/tresories/{idEntityAssociate}")
     * @Method("POST")
     */
    public function addTresorieToUser($id, $idEntityAssociate ) {
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

            $em = $this->getDoctrine()->getManager();
            $em->merge($entity);
            $em->flush();
        }
        return new Response(null, 201);
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

        return new Response(null, 201);
    }

}
