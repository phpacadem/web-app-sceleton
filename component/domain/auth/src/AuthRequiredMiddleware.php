<?php

namespace PhpAcadem\domain\Auth;


use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\domain\User\UserServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Session\SessionInterface;

class AuthRequiredMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';
    /** @var UserServiceInterface */
    protected $userService;

    /** @var SessionInterface */
    protected $session;

    /**
     * AuthMiddleware constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService, SessionInterface $session)
    {
        $this->userService = $userService;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = null;

        if (!$this->session || !$this->session->has(UserInterface::class)) {

            throw new AuthRequiredException();
        }
        if ($this->session->has(UserInterface::class)) {

            $userInfo = $this->session->get(UserInterface::class);
            if (!is_array($userInfo) || !isset($userInfo['id'])) {
                throw new AuthRequiredException();
            }

            $user = $this->userService->getById($userInfo['id']);
        }

        return $handler->handle($request->withAttribute(self::ATTRIBUTE, $user));
    }
}