<?php

namespace App\Service\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

use App\Entity\Security\RtlqAuthToken;

class AuthTokenUserProvider implements UserProviderInterface
{
    protected $authTokenRepository;
    protected $userRepository;

    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;
    }

    public function getAuthToken($authTokenHeader)
    {
        $rtlqAuthToken = $this->authTokenRepository->findOneBy(
        array('value' => $authTokenHeader)
        );

        return $rtlqAuthToken;
    }

    public function loadUserByUsername($email)
    {
        return $this->userRepository->loadUserByUsername($email);
    }

    public function refreshUser(UserInterface $user)
    {
        // Le systéme d'authentification est stateless, on ne doit donc jamais appeler la méthode refreshUser
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return 'App\Entity\Association\RtlqAdherent' === $class;
    }
}
