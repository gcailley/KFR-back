<?php

namespace App\Service\Security\User;

use App\Entity\Security\RtlqAuthToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\HttpUtils;

class AuthTokenAuthenticator extends AbstractGuardAuthenticator
{

    const X_AUTH_TOKEN = "X-Auth-Token";
    /**
     * Durée de validité du token en secondes, 30 jours.
     */
    const TOKEN_VALIDITY_DURATION = 30 * 24 * 3600;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports(Request $request)
    {
        return $request->headers->has(AuthTokenAuthenticator::X_AUTH_TOKEN);
    }

    public function getCredentials(Request $request)
    {
        return ['token' => $request->headers->get(AuthTokenAuthenticator::X_AUTH_TOKEN)];
    }

    /**
     * Vérifie la validité du token
     */
    private function isAuthTokenValid($authToken)
    {
        if ($authToken == null || $authToken->getCreatedAt() == null) {
            return false;
        } else {
            return (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION;
        }
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiToken = $credentials['token'];

        if (null == $apiToken) {
            return;
        }

        // if a User object, checkCredentials() is called
        $authToken = $this->em->getRepository(RtlqAuthToken::class)
            ->findOneBy(['value' =>  $apiToken]);
        
        if (null == $authToken || !$this->isAuthTokenValid($authToken)) {
            throw new CustomUserMessageAuthenticationException('Invalid authentication token : ' . $authToken);
        } 

        return $authToken->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
