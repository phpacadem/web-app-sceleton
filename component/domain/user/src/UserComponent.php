<?php

namespace PhpAcadem\domain\User;


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
            \PhpAcadem\domain\User\UserManager::class => function (\Psr\Container\ContainerInterface $c) {
                $pdo = $c->get(PDO::class);
                return new \PhpAcadem\domain\User\UserManager($pdo);
            },
            \PhpAcadem\domain\User\UserServiceInterface::class => function (\Psr\Container\ContainerInterface $c) {
                $userManager = $c->get(\PhpAcadem\domain\User\UserManager::class);
                return new \PhpAcadem\domain\User\UserService($userManager);
            },

            'commands' => [
                \PhpAcadem\domain\User\command\InitCommand::class => function (\Psr\Container\ContainerInterface $c) {
                    $pdo = $c->get(PDO::class);
                    $userService = $c->get(\PhpAcadem\domain\User\UserServiceInterface::class);
                    return new \PhpAcadem\domain\User\command\InitCommand($pdo, $userService);
                },
                \PhpAcadem\domain\User\command\UserAddCommand::class => function (\Psr\Container\ContainerInterface $c) {
                    $pdo = $c->get(PDO::class);
                    $userService = $c->get(\PhpAcadem\domain\User\UserServiceInterface::class);
                    return new \PhpAcadem\domain\User\command\UserAddCommand($pdo, $userService);
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