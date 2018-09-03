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

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function dtoToModele($em, $dto, $modele, $controller)
    {

        $adherentRepo = $em->getRepository('App:Association\RtlqAdherent');
        $adherentPossible = $adherentRepo->loadUserByUsername($dto->getLogin());

        if ($adherentPossible == null) { // L'utilisateur n'existe pas
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $isPasswordValid = $this->encoder->isPasswordValid($adherentPossible, $dto->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $modele->setValue(base64_encode(random_bytes(50)));
        $modele->setCreatedAt(new \DateTime('now'));

        //get adhernent from database to create the credentials
        $adherentRepo = $em->getRepository("App\Entity\Association\RtlqAdherent");
        $adherent = $adherentRepo->find($adherentPossible->getId());
        $modele->setUser($adherent);
        return $modele;
    }
    
    public function modeleToDto($modele,  $controller)
    {
		$dto = $controller->newDto();
        $dto->setToken ( $modele->getValue());
        $dto->setRoles ( $modele->getUser()->getRoles());
        $dto->setUsername ( $modele->getUser()->getUsername());

        return $dto;
    }
}
