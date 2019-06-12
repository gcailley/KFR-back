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
use App\Entity\Security\RtlqAuthToken;

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
        $entity = $this->getTokenByValue($request);

        // delete all keys
        $em = $this->getDoctrine()->getManager();
        $authTokenRepo = $em->getRepository(RtlqAuthToken::class);
        $entities = $authTokenRepo->findOldToken($entity->getUser(), AuthTokenAuthenticator::TOKEN_VALIDITY_DURATION);
        
        foreach ($entities as $entity) {
            $em->remove($entity);
        }
        $em->flush();

        $dto_entity = $this->builder->modeleToDto($entity, $this);
        return $this->newResponse(json_encode($dto_entity), Response::HTTP_ACCEPTED);
    }

    private function getTokenHeader(Request $request) {
        $authTokenHeader = $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN);
        if (!$authTokenHeader) {
            throw new BadCredentialsException(AuthTokenAuthenticator::X_AUTH_TOKEN . ' header is required');
        }
        return $authTokenHeader;
    }

    private function getTokenByValue(Request $request)
    {
        
        $authTokenHeader = $this->getTokenHeader($request);
        $em = $this->getDoctrine()->getManager();
        $authTokenRepo = $em->getRepository(RtlqAuthToken::class);
        $entity = $authTokenRepo->findValideToken($authTokenHeader, AuthTokenAuthenticator::TOKEN_VALIDITY_DURATION);

        if ($entity === null || empty($entity)) {
            throw $this->createAccessDeniedException();
        }

        return $entity[0];
    }


    /**
     * @Route("/logout", methods={"DELETE"})
     */
    public function logoutAction(Request $request)
    {
        $entity = $this->getTokenByValue($request);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->newResponse(null, Response::HTTP_NO_CONTENT);
    }


    public function getByIdAction(Request $request, $id)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /*
    public function getAllAction(Request $request, $response = true)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
    */

    public function updateAction($id, Request $request,  $response = true)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
