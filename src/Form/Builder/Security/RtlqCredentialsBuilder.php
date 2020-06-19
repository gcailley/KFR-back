<?php

namespace App\Form\Builder\Security;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use App\Form\Dto\Security\RtlqCredentialsDTO;
use App\Entity\Security\RtlqAuthToken;
use App\Form\Builder\AbstractRtlqBuilder;
use App\Entity\Association\RtlqAdherent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RtlqCredentialsBuilder extends AbstractRtlqBuilder
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder, $role_hierarchy)
    {
        $this->encoder = $encoder;
        $this->role_hierarchy = $role_hierarchy;
    }


    public function dtoToModele($em, $dto, $modele)
    {

        $adherentRepo = $em->getRepository(RtlqAdherent::class);
        $adherentPossible = $adherentRepo->loadUserByUsername($dto->getLogin());

        if ($adherentPossible == null) { // L'utilisateur n'existe pas
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $isPasswordValid = $this->encoder->isPasswordValid($adherentPossible, $dto->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $modele->setValue(bin2hex(random_bytes(50)));
        $modele->setCreatedAt(new \DateTime('now'));

        //get adhernent from database to create the credentials
        $adherentRepo = $em->getRepository("App\Entity\Association\RtlqAdherent");
        $adherent = $adherentRepo->find($adherentPossible->getId());
        $modele->setUser($adherent);
        return $modele;
    }
    
    public function modeleToDto($modele,  $dtoClass, $doctrine)
    {
        $dto = $this->getNewDto($dtoClass);
        $dto->setToken ( $modele->getValue());

        $roles = array();
        foreach ($modele->getUser()->getRoles() as $value) {
            if (array_key_exists ($value, $this->role_hierarchy)) {
                $roles = array_merge($roles, $this->role_hierarchy [$value]);
            } else {
                $roles [] = $value;
            }
        }
        $dto->setRoles ( $roles );
        $dto->setUsername ( $modele->getUser()->getUsername());

        return $dto;
    }

}
