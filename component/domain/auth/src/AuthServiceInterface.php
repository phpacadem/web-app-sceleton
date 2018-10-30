<?php

namespace PhpAcadem\domain\Auth;

use PhpAcadem\domain\User\UserInterface;

interface AuthServiceInterface
{
    public function authenticate($login = null, $password = null): ?UserInterface;
}