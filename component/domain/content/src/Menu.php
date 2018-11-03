<?php

namespace PhpAcadem\domain\Content;


class Menu implements MenuInterface
{

    /** @var  MenuItem[] */
    protected $menuItems;

    /**
     * @return MenuItem[]
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    /**
     * @param MenuItem[] $menuItems
     */
    public function setMenuItems(array $menuItems)
    {
        $this->menuItems = $menuItems;
    }

    public function addMenuItem(MenuItem $menuItem)
    {
        $this->menuItems[] = $menuItem;
    }

    public function getMenu()
    {
        return $this->menuItems;
    }
}