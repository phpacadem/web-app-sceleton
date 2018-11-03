<?php


namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;
use Infrastructure\EntityManager\EntityManager;

class SectionManager
{
    protected const TABLE_NAME = 'content_section';
    protected const ENTITY_CLASS_NAME = Section::class;
    /** @var EntityManager */
    protected $em;

    /**
     * SectionManager constructor.
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
            return $this->findBy(['status' => Section::STATUS_PUBLISHED]);
        }
        return $this->findBy([]);
    }

    public function findBy($conditions = [])
    {
        return $this->em->findBy(self::ENTITY_CLASS_NAME, $conditions);
    }

    public function findOneBy($conditions = []): ?Section
    {
        $result = $this->findBy($conditions);
        return array_shift($result);
    }

    public function fill(Section $section, $data = []): ?Section
    {
        /** @var Section $section */
        $section = $this->em->fill(self::ENTITY_CLASS_NAME, $section, $data);
        return $section;
    }

    public function create($data = []): ?Section
    {
        /** @var Section $section */
        $section = $this->em->create(self::ENTITY_CLASS_NAME, $data);
        return $section;
    }

    public function findById(int $id): ?Section
    {
        /** @var Section $section */
        $section = $this->em->findById(self::ENTITY_CLASS_NAME, $id);
        return $section;
    }

    public function save(EntityInterface $entity)
    {
        return $this->em->save(self::ENTITY_CLASS_NAME, $entity);
    }

}