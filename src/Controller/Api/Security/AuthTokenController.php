<?php

namespace App\Controller\Api\Security;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\json_encode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

use App\Controller\Api\AbstractCrudApiController;
use App\Form\Builder\Security\RtlqCredentialsBuilder;
use App\Form\Dto\Security\RtlqCredentialsDTO;
use App\Form\Validator\Security\RtlqCredentialsValidator;
use App\Entity\Association\RtlqAdherent;
use App\Service\Security\User\AuthTokenAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/security/tokens")
 */
class AuthTokenController extends AbstractCrudApiController
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->init();
    }

    
    function getName()
    {
        return 'App:Security\RtlqAuthToken';
    }

    function getNameType()
    {
        return "App\Form\Type\Security\RtlqCredentialsType";
    }

    protected function getBuilder()
    {
        return new RtlqCredentialsBuilder($this->encoder);
    }

    function newDto()
    {
        return new RtlqCredentialsDTO();
    }

    /**
     * Validateur par defaut ne faisant aucune validation spécifique sur le bean.
     *
     */
    public function getValidator()
    {
        return new RtlqCredentialsValidator();
    }

    public function preConditionCreationAction($em, $entityMetier)
    {
        return null;
    }

    public function getRoleHierarchy () {
        return $this->getParameter('security.role_hierarchy.roles');
    }

    /**
     * @Route("/check-user", methods={"GET"})
     */
    public function checkuserAction(Request $request)
    {
        // requete permettant de ne conserver aucun token sup à 5 pour cet utilisateur
        $entities = $this->getDoctrine()
            ->getRepository($this->getName())
            ->find(array("createdAt" < time() - AuthTokenAuthenticator::TOKEN_VALIDITY_DURATION));
        
        $em = $this->getDoctrine()->getManager();
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $em->flush();

        $entity = $this->getTokenByValue($request);
        if (!is_object($entity)) {
            throw $this->createAccessDeniedException();
        }

        return $this->newResponse(json_encode($entity), Response::HTTP_ACCEPTED);
    }

    private function getTokenByValue(Request $request) 
    {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        if (!$authTokenHeader) {
            throw new BadCredentialsException(AuthTokenAuthenticator::X_AUTH_TOKEN . ' header is required');
        }

        $entity = $this->getDoctrine()
                            ->getRepository($this->getName())
                                ->findOneBy(array("value"=>$authTokenHeader));

        return $entity;
    }


    /**
     * @Route("/logout", methods={"DELETE"})
     */
    public function logoutAction(Request $request)
    {
        $entity = $this->getTokenByValue($request);

        if (!is_object($entity)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->newResponse(null, Response::HTTP_NO_CONTENT);
    }


    public function getByIdAction(Request $request, $id)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function getAllAction(Request $request, $response = true)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function updateAction($id, Request $request,  $response = true)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
