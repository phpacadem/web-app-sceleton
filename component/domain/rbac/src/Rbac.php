<?php

namespace PhpAcadem\domain\Rbac;


class Rbac extends \Zend\Permissions\Rbac\Rbac
{
    /** @var  Rbac */
    protected $rbac;

    /**
     * @param array|string|\Zend\Permissions\Rbac\RoleInterface $roles
     * @param string $permission
     * @param null $assertion
     * @return bool
     */
    public function isGranted($roles, string $permission, $assertion = null): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (parent::isGranted($role, $permission, $assertion)) {
                    return true;
                }
            }
        } else {
            return parent::isGranted($roles, $permission, $assertion);
        }

        return false;

    }
}