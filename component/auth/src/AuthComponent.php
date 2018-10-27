<?php

namespace Auth;


use Interop\Container\ServiceProviderInterface;
use User\UserServiceInterface;

class AuthComponent implements ServiceProviderInterface
{

    /**
     * Returns a list of all container entries registered by this service provider.
     *
     * - the key is the entry name
     * - the value is a callable that will return the entry, aka the **factory**
     *
     * Factories have the following signature:
     *        function(\Psr\Container\ContainerInterface $container)
     *
     * @return callable[]
     */
    public function getFactories()
    {


        return [
            AuthMiddleware::class => function (\Psr\Container\ContainerInterface $c) {
                $userService = $c->get(UserServiceInterface::class);
                $session = $c->get(\Zend\Expressive\Session\SessionInterface::class);
                return new AuthMiddleware($userService, $session);
            },

            \Auth\AuthRequiredMiddleware::class => function (\Psr\Container\ContainerInterface $c) {
                $userService = $c->get(UserServiceInterface::class);
                $session = $c->get(\Zend\Expressive\Session\SessionInterface::class);
                return new \Auth\AuthRequiredMiddleware($userService, $session);
            },

            \Auth\AuthService::class => function (\Psr\Container\ContainerInterface $c) {
                $userService = $c->get(UserServiceInterface::class);
                $session = $c->get(\Zend\Expressive\Session\SessionInterface::class);
                return new \Auth\AuthService($userService, $session);
            },
        ];
    }

    /**
     * Returns a list of all container entries extended by this service provider.
     *
     * - the key is the entry name
     * - the value is a callable that will return the modified entry
     *
     * Callables have the following signature:
     *        function(Psr\Container\ContainerInterface $container, $previous)
     *     or function(Psr\Container\ContainerInterface $container, $previous = null)
     *
     * About factories parameters:
     *
     * - the container (instance of `Psr\Container\ContainerInterface`)
     * - the entry to be extended. If the entry to be extended does not exist and the parameter is nullable, `null` will be passed.
     *
     * @return callable[]
     */
    public function getExtensions()
    {
        // TODO: Implement getExtensions() method.
    }
}