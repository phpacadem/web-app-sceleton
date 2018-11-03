<?php

namespace app\controller\content;


use Cocur\Slugify\Slugify;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Content\Page;
use PhpAcadem\domain\Content\PageManager;
use PhpAcadem\domain\User\UserInterface;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageController extends ControllerAbstract
{
    /** @var  PageManager */
    protected $pageManager;

    /** @var Slugify */
    protected $slugify;

    /**
     * PageController constructor.
     * @param PageManager $pageManager
     * @param Slugify $slugify
     */
    public function __construct(PageManager $pageManager, Slugify $slugify)
    {
        $this->pageManager = $pageManager;
        $this->slugify = $slugify;
    }

    public function showAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $slug = $args['slug'] ?? null;

        if (empty($slug)) {
            throw  new NotFoundException();
        }
        $user = $request->getAttribute(UserInterface::class);

        $page = $this->pageManager->findOneBy(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED]);

        if (empty($page)) {
            throw  new NotFoundException();
        }

        if (empty($page)) {
            throw new NotFoundException('not found');
        }

        return $this->render('content/page/show', ['page' => $page, 'user' => $user]);
    }


}