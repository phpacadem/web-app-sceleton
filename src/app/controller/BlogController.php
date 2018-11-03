<?php

namespace app\controller;


use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Blog\PostManager;
use PhpAcadem\domain\User\UserInterface;
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
        $posts = $this->postManager->findAll();

        if (empty($posts)) {
            throw new NotFoundException('not found');
        }

        return $this->render('blog/index', ['posts' => $posts]);

    }

    public function showAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        $post = $this->postManager->getById($id);

        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        return $this->render('blog/show', ['post' => $post, 'user' => $request->getAttribute(UserInterface::class)]);
    }

    public function editAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        $post = $this->postManager->getById($id);

        if (empty($post)) {
            throw new NotFoundException('not found');
        }

        $requestData = $request->getParsedBody();

        if ('POST' === strtoupper($request->getMethod())) {
            $title = $requestData['title'] ?? '';
            $content = $requestData['content'] ?? '';

            $post->setTitle($title);
            $post->setContent($content);

            $this->postManager->save($post);
        }


        return $this->render('blog/edit', ['post' => $post]);
    }

}