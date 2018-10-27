<?php

namespace Auth;

use User\UserInterface;

interface AuthServiceInterface
{
    public function authenticate($login = null, $password = null): ?UserInterface;
}