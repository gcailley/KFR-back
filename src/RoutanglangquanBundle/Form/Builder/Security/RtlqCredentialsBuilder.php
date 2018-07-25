<?php

namespace RoutanglangquanBundle\Form\Builder\Security;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use RoutanglangquanBundle\Form\Dto\Security\RtlqCredentialsDTO;
use RoutanglangquanBundle\Entity\Security\RtlqAuthToken;
use RoutanglangquanBundle\Form\Builder\AbstractRtlqBuilder;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;

class RtlqCredentialsBuilder extends AbstractRtlqBuilder
{
    public function dtoToModele($em, $dto, $modele, $controller)
    {

        $adherentRepo = $em->getRepository('RoutanglangquanBundle:Association\RtlqAdherent');
        $adherentPossible = $adherentRepo->loadUserByUsername($dto->getLogin());

        if ($adherentPossible == null) { // L'utilisateur n'existe pas
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $encoder = $controller->getEncoder();
        $isPasswordValid = $encoder->isPasswordValid($adherentPossible, $dto->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            throw new UsernameNotFoundException('Invalid username or password');
        }

        $modele->setValue(base64_encode(random_bytes(50)));
        $modele->setCreatedAt(new \DateTime('now'));

        //get adhernent from database to create the credentials
        $adherentRepo = $em->getRepository("RoutanglangquanBundle\Entity\Association\RtlqAdherent");
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
