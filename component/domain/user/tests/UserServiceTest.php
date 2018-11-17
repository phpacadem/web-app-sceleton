<?php

namespace tests\framework\http;

use PhpAcadem\domain\User\User;
use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\domain\User\UserManager;
use PhpAcadem\domain\User\UserService;
use PhpAcadem\domain\User\UserServiceInterface;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    protected $userManager;
    protected $randomPassword;
    protected $wrongLogin;

    public function testInterface(): void
    {
        $this->assertInstanceOf(UserServiceInterface::class, new UserService($this->userManager));
    }

    public function testGetById(): void
    {
        $userService = new UserService($this->userManager);
        $UserId = rand(1, 99999);
        $this->assertEquals($userService->getById($UserId)->getId(), $UserId);

    }

    public function testLogin(): void
    {

        $userService = new UserService($this->userManager);

        $login = 'login' . rand(1, 99999);
        $this->assertInstanceOf(UserInterface::class, $userService->login($login, $this->randomPassword));
        $this->assertEquals($userService->login($login, $this->randomPassword)->getLogin(), $login);
        $this->assertNull($userService->login($login, $this->randomPassword . rand(1, 9999)));
        $this->assertNull($userService->login($this->wrongLogin, $this->randomPassword));
    }

    public function testCreate(): void
    {

        $userService = new UserService($this->userManager);

        $login = 'login' . rand(1, 99999);
        $password = $this->randomPassword;
        $roles = ['role1', ['role2']];
        $this->assertInstanceOf(UserInterface::class, $userService->create($login, $password));
        $this->assertInstanceOf(UserInterface::class, $userService->create($login, $password, $roles));
        $this->assertEquals($userService->create($login, $password)->getLogin(), $login);
    }

    public function testRegister(): void
    {

        $userService = new UserService($this->userManager);

        $login = 'login' . rand(1, 99999);
        $password = $this->randomPassword;
        $roles = ['role1', ['role2']];
        $this->assertInstanceOf(UserInterface::class, $userService->register($login, $password));
        $this->assertEquals($userService->register($login, $password)->getLogin(), $login);
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->randomPassword = 'password' . rand(100, 999);
        $this->wrongLogin = 'wrongLogin';
        $this->userManager = $this->getUserManager();
    }

    protected function getUserManager()
    {
        $userManger = $this->createMock(
            UserManager::class
        );
        $userManger->expects($this->any())
            ->method('getById')
            ->will($this->returnCallback(function ($id) {
                $user = $this->createMock(UserInterface::class);
                $user->expects($this->any())
                    ->method('getId')
                    ->will($this->returnCallback(function () use ($id) {
                        return $id;
                    }));
                return $user;
            }));

        $userManger->expects($this->any())
            ->method('getByLogin')
            ->will($this->returnCallback(function ($login) {

                if ($login == $this->wrongLogin) {
                    return null;
                }
                $user = new User();
                $user->setLogin($login);
                $user->setPasswordHash(password_hash($this->randomPassword, PASSWORD_DEFAULT));
                return $user;
            }));

        $userManger->expects($this->any())
            ->method('create')
            ->will($this->returnCallback(function ($login, $password, $roles = []) {
                $user = new User();
                $user->setLogin($login);
                $user->setPasswordHash(password_hash($password, PASSWORD_DEFAULT));
                if (!empty($roles)) {
                    $user->setRoles($roles);
                }
                return $user;
            }));

        return $userManger;
    }
}