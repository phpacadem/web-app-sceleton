<?php

namespace tests\framework\http;

use PhpAcadem\domain\User\User;
use PhpAcadem\domain\User\UserInterface;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testInterface(): void
    {
        $this->assertInstanceOf(UserInterface::class, new User());
    }

    public function testEmpty(): void
    {
        $user = new User([]);
        self::assertNull($user->getId());
        self::assertNull($user->getName());
        self::assertNull($user->getLogin());
        self::assertNull($user->getPasswordHash());
        self::assertTrue(empty($user->getRoles()));
    }

    public function testCreation(): void
    {
        $roles = ['role1', 'role2'];
        $userData = [
            'id' => 123,
            'name' => 'Name',
            'login' => 'Login',
            'password_hash' => 'Password_Hash',
            'roles' => json_encode($roles),
        ];
        $user = new User($userData);
        self::assertEquals($user->getId(), $userData['id']);
        self::assertEquals($user->getName(), $userData['name']);
        self::assertEquals($user->getLogin(), $userData['login']);
        self::assertEquals($user->getPasswordHash(), $userData['password_hash']);
        self::assertEquals(count($user->getRoles()), count($roles));
        foreach ($user->getRoles() as $role) {
            self::assertTrue(in_array($role, $roles));
        }

    }

    public function testFilling(): void
    {
        $roles = ['role1', 'role2'];
        $userData = [
            'id' => 123,
            'name' => 'Name',
            'login' => 'Login',
            'password_hash' => 'Password_Hash',
        ];
        $user = new User([]);
        $user->setId($userData['id']);
        $user->setName($userData['name']);
        $user->setLogin($userData['login']);
        $user->setPasswordHash($userData['password_hash']);
        $user->setRoles($roles);

        self::assertEquals($user->getId(), $userData['id']);
        self::assertEquals($user->getName(), $userData['name']);
        self::assertEquals($user->getLogin(), $userData['login']);
        self::assertEquals($user->getPasswordHash(), $userData['password_hash']);
        self::assertEquals(count($user->getRoles()), count($roles));
        foreach ($user->getRoles() as $role) {
            self::assertTrue(in_array($role, $roles));
        }

    }
}