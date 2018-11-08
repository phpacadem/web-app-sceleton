<?php

namespace tests\framework\http;

use Infrastructure\Hydrator\HydratorComponent;
use Interop\Container\ServiceProviderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class HydratorComponentTest extends TestCase
{

    public function testInterface(): void
    {
        $hydratorComponent = new HydratorComponent();
        $this->assertInstanceOf(ServiceProviderInterface::class, $hydratorComponent);
    }

    public function testGetExtensions(): void
    {
        $hydratorComponent = new HydratorComponent();
        $this->assertNull($hydratorComponent->getExtensions());

    }

    public function testGetFactories(): void
    {
        $hydratorComponent = new HydratorComponent();
        $this->assertTrue(is_array($hydratorComponent->getFactories()));
        $this->assertNotEquals(0, count($hydratorComponent->getFactories()));

        $container = $this->createContainer();

        foreach ($hydratorComponent->getFactories() as $class => $factory) {
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