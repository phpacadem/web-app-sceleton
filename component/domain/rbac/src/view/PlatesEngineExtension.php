<?php

namespace PhpAcadem\domain\Rbac\view;


use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use PhpAcadem\domain\Rbac\Rbac;

class PlatesEngineExtension implements ExtensionInterface
{
    /** @var  Rbac */
    protected $rbac;

    /**
     * PlatesEngineExtension constructor.
     * @param Rbac $rbac
     */
    public function __construct(Rbac $rbac)
    {
        $this->rbac = $rbac;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('rbac', [$this, 'getObject']);
    }

    public function getObject()
    {
        return $this;
    }

    public function isGranted($roles, $routeName)
    {
        return $this->rbac->isGranted($roles, $routeName);
    }

}