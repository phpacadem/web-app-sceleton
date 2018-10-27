<?php


namespace Auth;


use User\UserInterface;
use User\UserServiceInterface;
use Zend\Expressive\Session\SessionInterface;

class AuthService implements AuthServiceInterface
{
    /** @var UserServiceInterface */
    protected $userService;

    /** @var SessionInterface */
    protected $session;

    /**
     * AuthMiddleware constructor.
     * @param UserServiceInterface $userService
     * @param SessionInterface $session
     */
    public function __construct(UserServiceInterface $userService, SessionInterface $session)
    {
        $this->userService = $userService;
        $this->session = $session;
    }

    public function authenticate($login = null, $password = null): ?UserInterface
    {
        if (empty($login) || empty($password)) {
            throw new AuthFailedException();
        }

        if ($user = $this->userService->login($login, $password)) {
            $this->session->set(UserInterface::class,
                [
                    'id' => $user->getId(),
                    'login' => $user->getLogin(),
                    'name' => $user->getName(),
                ]
            );
            $this->session->regenerate();
        }

        if (empty($user)) {
            throw new AuthFailedException();
        }
        return $user;
    }

    public function logout(): void
    {
        $this->session->clear();
        $this->session->regenerate();
    }

}