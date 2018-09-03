<?php

namespace App\Form\Validator\Security;

use App\Form\Validator\AbstractRtlqValidator;
use App\Form\Validator\RtlqValidator;
use App\Entity\Association\RtlqAdherent;
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
