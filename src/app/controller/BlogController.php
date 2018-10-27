<?php

namespace app\controller;


use Blog\PostManager;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends ControllerAbstract
{

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        $postManager = $this->container->get(PostManager::class);
        $post = $postManager->getById($id);

        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        return $this->render('blog/show', ['post' => $post]);
    }

}