<?php

namespace app\controller\admin;


use PhpAcadem\domain\Content\PageManager;
use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends ControllerAbstract
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
        $user = $request->getAttribute(UserInterface::class) ?? null;


        $name = $user ? $user->getLogin() : 'Гость';
        return $this->render('admin/index', ['name' => $name]);
    }

}