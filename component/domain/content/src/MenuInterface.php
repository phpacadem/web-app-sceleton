<?php

namespace PhpAcadem\domain\Content;

interface MenuInterface
{
    /**
     * @return MenuItem[]
     */
    public function getMenuItems(): array;

    /**
     * @param MenuItem[] $menuItems
     */
    public function setMenuItems(array $menuItems);

    public function addMenuItem(MenuItem $menuItem);
}