<?php

namespace app\controller\content\admin;


use Cocur\Slugify\Slugify;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Content\ArticleManager;
use PhpAcadem\domain\Content\SectionManager;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleController extends ControllerAbstract
{
    /** @var  ArticleManager */
    protected $articleManager;

    /** @var  SectionManager */
    protected $sectionManager;

    /** @var Slugify */
    protected $slugify;

    /**
     * SectionController constructor.
     * @param ArticleManager $articleManager
     * @param SectionManager $sectionManager
     * @param Slugify $slugify
     */
    public function __construct(ArticleManager $articleManager, SectionManager $sectionManager, Slugify $slugify)
    {
        $this->articleManager = $articleManager;
        $this->sectionManager = $sectionManager;
        $this->slugify = $slugify;
    }

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {

        $sectionId = $args['id'] ?? null;

        if (empty($sectionId)) {
            throw new NotFoundException('not found');
        }

        $section = $this->sectionManager->findById($sectionId);

        if (empty($section)) {
            throw new NotFoundException('not found');
        }

        $articles = $this->articleManager->findBy(['section_id' => $section->getId()]);

        return $this->render('content/article/admin/index', ['articles' => $articles, 'section' => $section]);

    }


    public function editAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;
        $sectionId = $args['section_id'] ?? null;

        if ($id) {
            $article = $this->articleManager->findById($id);

            if (empty($article)) {
                throw new NotFoundException('not found');
            }
        }


        if ('POST' === strtoupper($request->getMethod())) {

            $requestData = $request->getParsedBody();

            if (!empty($article)) {
                $article = $this->articleManager->fill($article, $requestData);
            } else {
                $article = $this->articleManager->create($requestData);
            }

            $article->setSlug($this->slugify->slugify($article->getTitle()));

            $this->articleManager->save($article);
        }

        $sections = $this->sectionManager->findAll();

        $params = [
            'sections' => $sections,
        ];

        if (isset($article)) {
            $params['article'] = $article;
        }

        if (isset($sectionId)) {
            $params['sectionId'] = $sectionId;
        }

        return $this->render('content/article/admin/form', $params);
    }


}