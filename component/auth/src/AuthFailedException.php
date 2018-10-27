<?php

namespace Auth;


class AuthFailedException extends \Exception
{
    protected const CODE = 401;

    public function __construct()
    {
        parent::__construct('Auth failed', self::CODE);
    }

}