<?php

namespace Infrastructure\Session;


use Interop\Container\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Session\Ext\PhpSessionPersistence;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionPersistenceInterface;


class SessionComponent implements ServiceProviderInterface
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
            SessionInterface::class => function (\Psr\Container\ContainerInterface $c) {
                $sessionPersistence = $c->get(SessionPersistenceInterface::class);
                $request = $c->get(ServerRequestInterface::class);
                return $session = new \Zend\Expressive\Session\LazySession($sessionPersistence, $request);
            },

            \Infrastructure\Session\SessionMiddleware::class => function (\Psr\Container\ContainerInterface $c) {
                $session = $c->get(SessionInterface::class);
                $sessionPersistence = $c->get(SessionPersistenceInterface::class);
                return new \Infrastructure\Session\SessionMiddleware($session, $sessionPersistence);
            },

            SessionPersistenceInterface::class => function () {
                return new PhpSessionPersistence();
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