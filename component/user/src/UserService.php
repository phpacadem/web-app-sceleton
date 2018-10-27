<?php


namespace User;


class UserService implements UserServiceInterface
{
    /** @var UserManager */
    protected $userManager;

    /**
     * UserService constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    public function getById($id): ?UserInterface
    {
        return $this->userManager->getById($id);
    }

    public function login($login, $password): ?UserInterface
    {
        $user = $this->userManager->getByLogin($login);
        if ($user) {
            if (password_verify($password, $user->getPasswordHash())) {
                return $user;
            }
        } else {
            password_hash($password, PASSWORD_DEFAULT);
        }
        return null;
    }


    public function register($login, $password)
    {
        return $this->userManager->create($login, $password);
    }

}