<?php

namespace PhpAcadem\domain\Rbac;


class Rbac extends \Zend\Permissions\Rbac\Rbac
{
    /** @var  Rbac */
    protected $rbac;

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