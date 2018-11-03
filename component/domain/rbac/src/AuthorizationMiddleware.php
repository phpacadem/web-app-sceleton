<?php

namespace PhpAcadem\domain\Rbac;


use PhpAcadem\domain\Auth\AuthRequiredException;
use PhpAcadem\domain\User\UserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Authorization\AuthorizationInterface;

class AuthorizationMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;


    public function __construct(AuthorizationInterface $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $request->getAttribute(UserInterface::class, false);
        if (!$user instanceof UserInterface) {
            throw new AuthRequiredException();
        }

        foreach ($user->getRoles() as $role) {
            if ($this->authorization->isGranted($role, $request)) {
                return $handler->handle($request);
            }
        }
        throw new ForbiddenException();
    }
}