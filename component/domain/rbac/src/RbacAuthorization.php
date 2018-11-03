<?php

declare(strict_types=1);

namespace PhpAcadem\domain\Rbac;

use PhpAcadem\framework\route\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Authorization\AuthorizationInterface;
use Zend\Expressive\Authorization\Exception;
use Zend\Expressive\Router\RouteResult;
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;


class RbacAuthorization implements AuthorizationInterface
{
    /**
     * @var Rbac
     */
    private $rbac;
    /**
     * @var null|AssertionInterface
     */
    private $assertion;

    public function __construct(Rbac $rbac, AssertionInterface $assertion = null)
    {
        $this->rbac = $rbac;
        $this->assertion = $assertion;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception\RuntimeException
     */
    public function isGranted(string $role, ServerRequestInterface $request): bool
    {
        /** @var Route $route */
        $route = $request->getAttribute('route', false);
        if (false === $route) {
            throw new Exception\RuntimeException(sprintf(
                'The %s attribute is missing in the request; cannot perform authorizations',
                'route'
            ));
        }
        $routeName = $route->getName();

        if ($group = $route->getParentGroup()) {
            return $this->rbac->isGranted($role, $group->getName(), $this->assertion);
        }

        return $this->rbac->isGranted($role, $routeName, $this->assertion);
    }
}