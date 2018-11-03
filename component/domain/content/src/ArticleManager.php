<?php


namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;
use Infrastructure\EntityManager\EntityManager;

class ArticleManager
{
    protected const TABLE_NAME = 'content_article';
    protected const ENTITY_CLASS_NAME = Article::class;
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
            return $this->findBy(['status' => Article::STATUS_PUBLISHED]);
        }
        return $this->findBy([]);
    }

    public function findBy($conditions = [])
    {
        return $this->em->findBy(self::ENTITY_CLASS_NAME, $conditions);
    }

    public function deleteById($id)
    {
        return $this->em->deleteById(self::ENTITY_CLASS_NAME, $id);
    }

    public function findOneBy($conditions = [])
    {
        $result = $this->findBy($conditions);
        return array_shift($result);
    }

    public function fill(Article $article, $data = []): ?Article
    {
        /** @var Article $article */
        $article = $this->em->fill(self::ENTITY_CLASS_NAME, $article, $data);
        return $article;
    }

    public function create($data = []): ?Article
    {
        /** @var Article $article */
        $article = $this->em->create(self::ENTITY_CLASS_NAME, $data);
        return $article;
    }

    public function findById(int $id): ?Article
    {
        /** @var Article $article */
        $article = $this->em->findById(self::ENTITY_CLASS_NAME, $id);
        return $article;
    }

    public function save(EntityInterface $entity)
    {
        return $this->em->save(self::ENTITY_CLASS_NAME, $entity);
    }

}