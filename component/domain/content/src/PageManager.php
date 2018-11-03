<?php


namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;
use Infrastructure\EntityManager\EntityManager;

class PageManager
{
    protected const TABLE_NAME = 'content_page';
    protected const ENTITY_CLASS_NAME = Page::class;

    /** @var EntityManager */
    protected $em;

    /**
     * ArticleManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $em->addEntitySupport(self::TABLE_NAME, self::ENTITY_CLASS_NAME);
    }

    public function findAll($published = true)
    {
        if ($published) {
            return $this->findBy(['status' => Page::STATUS_PUBLISHED]);
        }
        return $this->findBy([]);
    }

    public function findBy($conditions = [])
    {
        return $this->em->findBy(self::ENTITY_CLASS_NAME, $conditions);
    }

    public function findOneBy($conditions = [])
    {
        $result = $this->findBy($conditions);
        return array_shift($result);
    }

    public function fill(Page $section, $data = []): ?Page
    {
        /** @var Page $section */
        $section = $this->em->fill(self::ENTITY_CLASS_NAME, $section, $data);
        return $section;
    }

    public function create($data = []): ?Page
    {
        /** @var Page $page */
        $page = $this->em->create(self::ENTITY_CLASS_NAME, $data);
        return $page;
    }

    public function findById(int $id): ?Page
    {
        /** @var Page $article */
        $article = $this->em->findById(self::ENTITY_CLASS_NAME, $id);
        return $article;
    }

    public function save(EntityInterface $entity)
    {
        return $this->em->save(self::ENTITY_CLASS_NAME, $entity);
    }

}