<?php

namespace tests\framework\http;

use Interop\Container\ServiceProviderInterface;
use PhpAcadem\domain\User\UserComponent;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class UserComponentTest extends TestCase
{
    protected $userManager;
    protected $randomPassword;
    protected $wrongLogin;

    public function testInterface(): void
    {
        $userComponent = new UserComponent();
        $this->assertInstanceOf(ServiceProviderInterface::class, $userComponent);
    }

    public function testGetExtensions(): void
    {
        $userComponent = new UserComponent();
        $this->assertNull($userComponent->getExtensions());

    }

    public function testGetFactories(): void
    {
        $userComponent = new UserComponent();
        $this->assertTrue(is_array($userComponent->getFactories()));
        $this->assertNotEquals(0, count($userComponent->getFactories()));

        $container = $this->createContainer();

        foreach ($userComponent->getFactories() as $class => $factory) {
            if ($class == 'commands') {
                $commandFactories = $factory;
                foreach ($commandFactories as $commandClass => $commandFactory) {
                    $object = $commandFactory($container);
                    $this->assertInstanceOf($commandClass, $object);
                }
                continue;
            }
            $object = $factory($container);

            $this->assertInstanceOf($class, $object);
        }

    }

    protected function createContainer()
    {
        $container = $this->createMock(
            ContainerInterface::class
        );
        $container->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function ($className) {
                if (!class_exists($className) && !interface_exists($className)) {
                    throw new \Exception($className);
                }
                return $this->createMock($className);
            }));
        return $container;
    }

}