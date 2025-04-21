<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class InvalidCaptchaException extends AuthenticationException
{
    public function getMessageKey()
    {
        return "Captcha inválido.";
    }
}
