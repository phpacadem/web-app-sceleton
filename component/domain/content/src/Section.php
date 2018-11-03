<?php

namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;

class Section implements EntityInterface
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;

    protected $id;
    protected $title;
    protected $slug;
    protected $status;

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
    public function setId($id): void
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
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}