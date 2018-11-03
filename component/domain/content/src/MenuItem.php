<?php

namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;

class MenuItem implements EntityInterface
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;

    protected $id;
    protected $title;
    protected $url;
    protected $sort;
    protected $is_special;

    /**
     * Article constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $datum) {
            if (property_exists($this, $key)) {
                $this->$key = $datum;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getisSpecial()
    {
        return $this->is_special;
    }

    /**
     * @param mixed $is_special
     */
    public function setIsSpecial($is_special)
    {
        $this->is_special = $is_special;
    }


}