<?php

return [
    new \Infrastructure\EntityManager\EntityManagerComponent(),
    new \Infrastructure\Hydrator\HydratorComponent(),
    new \Infrastructure\PDO\PdoComponent(),
    new \Infrastructure\Session\SessionComponent(),
    new \PhpAcadem\domain\Auth\AuthComponent(),
    new \PhpAcadem\domain\Blog\BlogComponent(),
    new \PhpAcadem\domain\Content\ContentComponent(),
    new \PhpAcadem\domain\User\UserComponent(),
    new \PhpAcadem\domain\Rbac\RbacComponent(),
];