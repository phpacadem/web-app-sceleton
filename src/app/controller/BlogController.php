<?php

namespace app\controller;


use framework\controller\ControllerAbstract;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends ControllerAbstract
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

// try errors
//        echo й($w['31213']);
//        throw new \Exception('fsd');
//        throw new NotFoundException('fsd');


        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        $post['catalog'] = $this->getContainer()->get('dummy');

        return $this->render('blog/show', $post);

    }

}