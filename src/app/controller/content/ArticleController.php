<?php

namespace app\controller\content;


use Cocur\Slugify\Slugify;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Content\Article;
use PhpAcadem\domain\Content\ArticleManager;
use PhpAcadem\domain\Content\SectionManager;
use PhpAcadem\domain\User\UserInterface;
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
        $sectionSlug = $args['section'] ?? null;
        if (empty($sectionSlug)) {
            throw  new NotFoundException();
        }
        $section = $this->sectionManager->findOneBy(['slug' => $sectionSlug]);
        if (empty($section)) {
            throw  new NotFoundException();
        }
        $articles = $this->articleManager->findBy(['section_id' => $section->getId(), 'status' => Article::STATUS_PUBLISHED]);

        return $this->render('content/article/index', ['section' => $section, 'articles' => $articles]);

    }

    public function showAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $slug = $args['slug'] ?? null;

        if (empty($slug)) {
            throw  new NotFoundException();
        }
        /** @var UserInterface $user */
        $user = $request->getAttribute(UserInterface::class);

        $conditions = [
            'slug' => $slug,
            'status' => Article::STATUS_PUBLISHED,
        ];

        if ($user && in_array('admin', $user->getRoles())) {
            unset($conditions['status']);
        }

        $article = $this->articleManager->findOneBy($conditions);

        if (empty($article)) {
            throw  new NotFoundException();
        }

        if (empty($article)) {
            throw new NotFoundException('not found');
        }

        return $this->render('content/article/show', ['article' => $article, 'user' => $user]);
    }

}