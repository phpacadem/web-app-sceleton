<?php
/**
 * @2016-2017 ООО "Маркетплейс" (goods.ru)
 * Все права защищены.
 * Создано: 19.10.18 Иван Цимбалист <ivan.tsimbalist@lenvendo.ru>
 */

namespace app\controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getQueryParams()['name'] ?? 'Гость';
        return new \Zend\Diactoros\Response\HtmlResponse('Привет ' . $name . '!');
    }

}