<?php

namespace app\controller;


use Blog\PostManager;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends ControllerAbstract
{
    /** @var  PostManager */
    protected $postManager;

    /**
     * BlogController constructor.
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        $post = $this->postManager->getById($id);

        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        return $this->render('blog/show', ['post' => $post]);
    }

}