<?php

namespace app\controller\content\admin;


use Cocur\Slugify\Slugify;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\domain\Content\SectionManager;
use PhpAcadem\framework\controller\ControllerAbstract;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SectionController extends ControllerAbstract
{
    /** @var  SectionManager */
    protected $sectionManager;

    /** @var Slugify */
    protected $slugify;

    /**
     * SectionController constructor.
     * @param SectionManager $sectionManager
     * @param Slugify $slugify
     */
    public function __construct(SectionManager $sectionManager, Slugify $slugify)
    {
        $this->sectionManager = $sectionManager;
        $this->slugify = $slugify;
    }

    public function indexAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $sections = $this->sectionManager->findAll(false);

        return $this->render('content/section/admin/index', ['sections' => $sections]);

    }

    public function editAction(ServerRequestInterface $request, $args): ResponseInterface
    {
        $id = $args['id'] ?? null;

        if ($id) {
            $section = $this->sectionManager->findById($id);

            if (empty($section)) {
                throw new NotFoundException('not found');
            }
        }


        if ('POST' === strtoupper($request->getMethod())) {

            $requestData = $request->getParsedBody();

            if (!empty($section)) {
                $section = $this->sectionManager->fill($section, $requestData);
            } else {
                $section = $this->sectionManager->create($requestData);
            }

            $section->setSlug($this->slugify->slugify($section->getTitle()));

            $this->sectionManager->save($section);
        }

        $params = [];
        if (isset($section)) {
            $params['section'] = $section;
        }


        return $this->render('content/section/admin/form', $params);
    }


}