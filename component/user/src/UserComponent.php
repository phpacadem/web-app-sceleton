<?php

namespace User;


use Interop\Container\ServiceProviderInterface;
use PDO;

class UserComponent implements ServiceProviderInterface
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
            \User\UserManager::class => function (\Psr\Container\ContainerInterface $c) {
                $pdo = $c->get(PDO::class);
                return new \User\UserManager($pdo);
            },
            \User\UserServiceInterface::class => function (\Psr\Container\ContainerInterface $c) {
                $userManager = $c->get(\User\UserManager::class);
                return new \User\UserService($userManager);
            },

            'commands' => [
                \User\command\InitCommand::class => function (\Psr\Container\ContainerInterface $c) {
                    $pdo = $c->get(PDO::class);
                    $userService = $c->get(\User\UserServiceInterface::class);
                    return new \User\command\InitCommand($pdo, $userService);
                },
            ],

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