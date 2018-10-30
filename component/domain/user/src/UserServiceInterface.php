<?php

namespace PhpAcadem\domain\User;

interface UserServiceInterface
{
    public function getById($id): ?UserInterface;

    public function login($login, $password): ?UserInterface;

    public function register($login, $password);
}