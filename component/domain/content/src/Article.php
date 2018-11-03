<?php

namespace PhpAcadem\domain\Content;


use Infrastructure\EntityManager\EntityInterface;

class Article implements EntityInterface
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;
    protected $id;
    protected $title;
    protected $slug;
    protected $content;
    protected $section_id;
    protected $status;
    protected $created_at;
    protected $updated_at;

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

    public function getAnnotation(int $n = 400)
    {
        return mb_substr(trim(strip_tags($this->getContent())), 0, $n) . '...';
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSectionId()
    {
        return $this->section_id;
    }

    /**
     * @param mixed $section_id
     */
    public function setSectionId($section_id): void
    {
        $this->section_id = $section_id;
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

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        static $statuses = [
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_PUBLISHED => 'Опубликована',
        ];
        return $statuses[$this->status];
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return date('d.m.Y H:i:s', $this->created_at);
//        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return date('d.m.Y H:i:s', $this->updated_at);
//        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }


}