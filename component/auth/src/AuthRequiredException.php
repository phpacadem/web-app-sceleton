<?php

namespace Auth;


class AuthRequiredException extends \Exception
{
    protected const CODE = 401;

    public function __construct()
    {
        parent::__construct('Auth required', self::CODE);
    }

}