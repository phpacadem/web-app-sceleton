<?php


namespace app\route;


class RouteMap
{
    public const ADMIN = "admin";

    public const CONTENT_ADMIN_SECTION = "section.admin";
    public const CONTENT_ADMIN_SECTION_INDEX = "section.admin.index";
    public const CONTENT_ADMIN_SECTION_NEW = "section.admin.new";
    public const CONTENT_ADMIN_SECTION_EDIT = "section.admin.edit";
    public const CONTENT_ADMIN_SECTION_SAVE = "section.admin.save";


    public const CONTENT_ARTICLE_INDEX = "article.index";
    public const CONTENT_ARTICLE_SHOW = "article.show";

    public const CONTENT_ADMIN_ARTICLE = "article.admin";
    public const CONTENT_ADMIN_ARTICLE_INDEX = "article.admin.index";
    public const CONTENT_ADMIN_ARTICLE_NEW = "article.admin.new";
    public const CONTENT_ADMIN_ARTICLE_EDIT = "article.admin.edit";
    public const CONTENT_ADMIN_ARTICLE_SAVE = "article.admin.save";

    public const CONTENT_PAGE_SHOW = "page.show";

    public const CONTENT_ADMIN_PAGE = "page.admin";
    public const CONTENT_ADMIN_PAGE_INDEX = "page.admin.index";
    public const CONTENT_ADMIN_PAGE_NEW = "page.admin.new";
    public const CONTENT_ADMIN_PAGE_EDIT = "page.admin.edit";
    public const CONTENT_ADMIN_PAGE_SAVE = "page.admin.save";

    public const CONTENT_ADMIN_MENU = "menu.admin";
    public const CONTENT_ADMIN_MENU_INDEX = "menu.admin.index";
    public const CONTENT_ADMIN_MENU_NEW = "menu.admin.new";
    public const CONTENT_ADMIN_MENU_EDIT = "menu.admin.edit";
    public const CONTENT_ADMIN_MENU_SAVE = "menu.admin.save";

    public static function getAdminRoutes()
    {
        return [
            self::ADMIN,
            self::CONTENT_ADMIN_SECTION,
            self::CONTENT_ADMIN_ARTICLE,
            self::CONTENT_ADMIN_PAGE,
            self::CONTENT_ADMIN_MENU,
        ];
    }
}