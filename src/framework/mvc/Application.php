<?php
/**
 * @2016-2017 ООО "Маркетплейс" (goods.ru)
 * Все права защищены.
 * Создано: 19.10.18 Иван Цимбалист <ivan.tsimbalist@lenvendo.ru>
 */

namespace framework\mvc;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application implements RequestHandlerInterface
{

    /**
     * Handle the request and return a response.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement handle() method.
    }
}