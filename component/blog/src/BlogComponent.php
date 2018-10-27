<?php

namespace Blog;


use Interop\Container\ServiceProviderInterface;

class BlogComponent implements ServiceProviderInterface
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
            \Blog\PostManager::class => function (\Psr\Container\ContainerInterface $c) {
                $pdo = $c->get(\PDO::class);
                return new \Blog\PostManager($pdo);
            },

            'commands' => [
                \Blog\command\InitCommand::class => function (\Psr\Container\ContainerInterface $c) {
                    $pdo = $c->get(\PDO::class);
                    $userService = $c->get(\User\UserServiceInterface::class);
                    return new \Blog\command\InitCommand($pdo, $userService);
                },
            ],
        ];

    }

    public function getExtensions()
    {
    }
}