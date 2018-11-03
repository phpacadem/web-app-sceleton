<?php

namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityManager;
use Interop\Container\ServiceProviderInterface;

class ContentComponent implements ServiceProviderInterface
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
            ArticleManager::class => function (\Psr\Container\ContainerInterface $c) {
                $em = $c->get(EntityManager::class);
                $articleManager = new ArticleManager($em);
                return $articleManager;
            },

            'commands' => [
                command\InitCommand::class => function (\Psr\Container\ContainerInterface $c) {
                    $pdo = $c->get(\PDO::class);
                    $userService = $c->get(\PhpAcadem\domain\User\UserServiceInterface::class);
                    return new command\InitCommand($pdo, $userService);
                },
            ],
        ];

    }

    public function getExtensions()
    {
    }
}