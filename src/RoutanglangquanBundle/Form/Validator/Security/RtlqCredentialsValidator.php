<?php

namespace RoutanglangquanBundle\Form\Validator\Security;

use RoutanglangquanBundle\Form\Validator\AbstractRtlqValidator;
use RoutanglangquanBundle\Form\Validator\RtlqValidator;
use RoutanglangquanBundle\Entity\Association\RtlqAdherent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class RtlqCredentialsValidator extends RtlqValidator
{
    function doPostValidateDto($dto)
    {

        $errors = array();
        if (!($dto->getLogin() != "" && $dto->getPassword()  != "")) {
            $errors[] = "Username and password are required";
        }

        return $errors;
    }
}
