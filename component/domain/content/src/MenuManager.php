<?php


namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;
use Infrastructure\EntityManager\EntityManager;

class MenuManager
{
    protected const TABLE_NAME = 'content_menu';
    protected const ENTITY_CLASS_NAME = MenuItem::class;
    /** @var EntityManager */
    protected $em;

    /**
     * MenuManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $em->addEntitySupport(self::TABLE_NAME, self::ENTITY_CLASS_NAME);
    }

    /**
     * @return MenuInterface
     */
    public function getMenu()
    {
        $menuItems = $this->findAll();
        usort($menuItems, function ($a, $b) {
            /** @var MenuItem $a */
            /** @var MenuItem $b */
            if ($a->getSort() == $b->getSort()) {
                return 0;
            }
            return ($a->getSort() < $b->getSort()) ? -1 : 1;
        });
        $menu = new Menu();
        $menu->setMenuItems($menuItems);
        return $menu;
    }

    public function findAll()
    {
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

    public function fill(MenuItem $menu, $data = []): ?MenuItem
    {
        /** @var MenuItem $menu */
        $menu = $this->em->fill(self::ENTITY_CLASS_NAME, $menu, $data);
        return $menu;
    }

    public function create($data = []): ?MenuItem
    {
        /** @var MenuItem $menu */
        $menu = $this->em->create(self::ENTITY_CLASS_NAME, $data);
        return $menu;
    }

    public function findById(int $id): ?MenuItem
    {
        /** @var MenuItem $menu */
        $menu = $this->em->findById(self::ENTITY_CLASS_NAME, $id);
        return $menu;
    }

    public function save(EntityInterface $entity)
    {
        return $this->em->save(self::ENTITY_CLASS_NAME, $entity);
    }

}