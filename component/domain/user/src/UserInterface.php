<?php

namespace PhpAcadem\domain\User;

interface UserInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     */
    public function setId($id): void;

    /**
     * @return array
     */
    public function getRoles();

    /**
     * @param mixed $roles
     */
    public function setRoles(array $roles): void;


    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     */
    public function setName($name): void;

    /**
     * @return mixed
     */
    public function getLogin();

    /**
     * @param mixed $login
     */
    public function setLogin($login): void;

    /**
     * @return mixed
     */
    public function getPasswordHash();

    /**
     * @param mixed $password_hash
     */
    public function setPasswordHash($password_hash): void;
}