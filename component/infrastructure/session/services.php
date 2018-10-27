<?php

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Session\Ext\PhpSessionPersistence;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionPersistenceInterface;

return [
    /// Подумать что делать с сессией, она нужна но уж слишком сложно конфигурится - п
    ///
    /// Думаю надо запилить компонент сессий
    ///
    SessionInterface::class => DI\factory(function (SessionPersistenceInterface $sessionPersistence, ServerRequestInterface $request) {
        return $session = new \Zend\Expressive\Session\LazySession($sessionPersistence, $request);
    }),

    \Infrastructure\Session\SessionMiddleware::class => DI\factory(function (SessionInterface $session, SessionPersistenceInterface $sessionPersistence) {
        return new \Infrastructure\Session\SessionMiddleware($session, $sessionPersistence);
    }),

    SessionPersistenceInterface::class => DI\factory(function () {
        return new PhpSessionPersistence();
    }),
    //////////////////////////////
];