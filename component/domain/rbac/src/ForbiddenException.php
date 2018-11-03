<?php

namespace PhpAcadem\domain\Rbac;


class ForbiddenException extends \Exception
{
    protected const CODE = 403;

    public function __construct()
    {
        parent::__construct('Forbidden', self::CODE);
    }

}