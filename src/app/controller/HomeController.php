<?php

namespace app\controller;


use PhpAcadem\domain\Content\Page;
use PhpAcadem\domain\Content\PageManager;
use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends ControllerAbstract
{
    /** @var  PageManager */
    protected $pageManager;

    /**
     * HomeController constructor.
     * @param PageManager $pageManager
     */
    public function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $pageSlug = "main";
        $page = $this->pageManager->findOneBy(['slug' => $pageSlug, 'status' => Page::STATUS_PUBLISHED]);
        $user = $request->getAttribute(UserInterface::class) ?? null;
        if ($page) {
            return $this->render('content/page/show', ['page' => $page, 'user' => $user]);
        }


        $name = $user ? $user->getLogin() : 'Гость';
        return $this->render('home/index', ['name' => $name]);
    }

}