<?php

namespace app\controller\content\admin;


use Cocur\Slugify\Slugify;
use PhpAcadem\domain\Content\PageManager;
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

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $pages = $this->pageManager->findAll(false);

        return $this->render('content/page/admin/index', ['pages' => $pages]);

    }


    public function editAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $page = $this->pageManager->findById($id);

            if (empty($page)) {
                throw new NotFoundException('not found');
            }
        }


        if ('POST' === strtoupper($request->getMethod())) {

            $requestData = $request->getParsedBody();

            if (!empty($page)) {
                $page = $this->pageManager->fill($page, $requestData);
            } else {
                $page = $this->pageManager->create($requestData);
            }

            $page->setSlug($this->slugify->slugify($page->getTitle()));

            $this->pageManager->save($page);
        }
        $params = [];
        if (isset($page)) {
            $params['page'] = $page;
        }

        return $this->render('content/page/admin/form', $params);
    }

}