<?php

use Auth\AuthMiddleware;
use User\UserServiceInterface;

return [
    AuthMiddleware::class => DI\factory(function (UserServiceInterface $userService, \Zend\Expressive\Session\SessionInterface $session) {
        return new AuthMiddleware($userService, $session);
    }),

    \Auth\AuthRequiredMiddleware::class => DI\factory(function (UserServiceInterface $userService, \Zend\Expressive\Session\SessionInterface $session) {
        return new \Auth\AuthRequiredMiddleware($userService, $session);
    }),

    \Auth\AuthService::class => DI\factory(function (UserServiceInterface $userService, \Zend\Expressive\Session\SessionInterface $session) {
        return new \Auth\AuthService($userService, $session);
    })
];