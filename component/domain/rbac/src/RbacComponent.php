<?php

namespace PhpAcadem\domain\Rbac;


use Interop\Container\ServiceProviderInterface;
use PhpAcadem\domain\Rbac\view\PlatesEngineExtension;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Authorization\AuthorizationInterface;

class RbacComponent implements ServiceProviderInterface
{
    protected const RBAC_CONFIG_NAME = 'rbac';

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
            AuthorizationMiddleware::class => function (AuthorizationInterface $authorization) {
                return new AuthorizationMiddleware($authorization);
            },

            AuthorizationInterface::class => function (Rbac $rbac) {
                return new RbacAuthorization($rbac);
            },

            Rbac::class => function (\Psr\Container\ContainerInterface $c) {
                $config = $c->get(self::RBAC_CONFIG_NAME);

                $rbac = new Rbac();
                $rbac->setCreateMissingRoles(true);

                // roles and parents
                foreach ($config['roles'] as $role => $parents) {
                    $rbac->addRole($role, $parents);
                }

                // permissions
                foreach ($config['permissions'] as $role => $permissions) {
                    foreach ($permissions as $perm) {
                        $rbac->getRole($role)->addPermission($perm);
                    }
                }

                return $rbac;
            },

            'viewExtensions' => [
                PlatesEngineExtension::class => function (ContainerInterface $c) {
                    return new PlatesEngineExtension($c->get(Rbac::class));
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