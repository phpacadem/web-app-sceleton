<?php
/**
 * @2016-2017 ООО "Маркетплейс" (goods.ru)
 * Все права защищены.
 * Создано: 19.10.18 Иван Цимбалист <ivan.tsimbalist@lenvendo.ru>
 */

namespace app\controller;


use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    protected $posts = [
        1 => [
            'name' => "Первый пост",
            'text' => "Первый пост ро первый пост",
        ],
        2 => [
            'name' => "Второй пост",
            'text' => "Второй пост ро первый пост",
        ]
    ];

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;
        $post = $this->posts[$id] ?? null;

        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        return new \Zend\Diactoros\Response\HtmlResponse('<h1>' . $post['name'] . '</h1> <p>' . $post['text'] . '</p>');
    }

}