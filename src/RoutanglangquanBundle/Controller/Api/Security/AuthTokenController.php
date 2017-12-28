<?php

namespace RoutanglangquanBundle\Controller\Api\Security;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

use RoutanglangquanBundle\Controller\Api\AbstractCrudApiController;
use RoutanglangquanBundle\Form\Builder\Security\RtlqCredentialsBuilder;
use RoutanglangquanBundle\Form\Dto\Security\RtlqCredentialsDTO;
use RoutanglangquanBundle\Form\Validator\Security\RtlqCredentialsValidator;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use RoutanglangquanBundle\Service\Security\User\AuthTokenAuthenticator;

/**
 * @Route("/security/tokens")
 */
class AuthTokenController extends AbstractCrudApiController
{

    
    function getName()
    {
        return 'RoutanglangquanBundle:Security\RtlqAuthToken';
    }

    function getNameType()
    {
        return "RoutanglangquanBundle\Form\Type\Security\RtlqCredentialsType";
    }

    protected function getBuilder()
    {
        return new RtlqCredentialsBuilder();
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


    /**
     * @Route("/check-user")
     * @Method("GET")
     */
    public function checkuserAction(Request $request)
    {
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
     * @Route("/logout")
     * @Method("DELETE")
     */
    public function logoutAction(Request $request)
    {
        $entity = $this->getTokenByValue($request);

        if (!is_object($entity)) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $this->internalDeleteByIdAction($em, $entity);
        $em->remove($entity);
        $em->flush();

        return $this->newResponse(null, Response::HTTP_NO_CONTENT);
    }


    public function getByIdAction($id)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }


    public function getAllAction(Request $request)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function updateAction($id, Request $request)
    {
        return $this->newResponse(null, Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
