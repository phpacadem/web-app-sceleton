<?php


namespace PhpAcadem\domain\Blog;


use PDO;

class PostManager
{
    /** @var PDO */
    protected $pdo;

    /**
     * UserManager constructor.
     * @param  PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll()
    {
        $stmt = $this->pdo->prepare("select * from post");
        $stmt->execute([
        ]);

        $posts = [];
        while ($postData = $stmt->fetch()) {
            if (empty($postData)) {
                continue;
            }

            $post = new Post($postData);

            $posts[$post->getId()] = $post;
        }

        return $posts;
    }

    public function getById(int $id): ?Post
    {
        $stmt = $this->pdo->prepare("select * from post where id=:id");
        $stmt->execute([
            'id' => $id
        ]);

        $postData = $stmt->fetch();
        if (empty($postData)) {
            return null;
        }

        return new Post($postData);

    }

    public function save(Post $post)
    {
        try {
            if ($post->getId()) {
                $stmt = $this->pdo->prepare("update post set title=:title, content=:content where id=:id");
                $result = $stmt->execute([
                    'id' => $post->getId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent(),
                ]);
                return $result;
            }

        } catch (\PDOException $e) {
            return false;
        }


    }

}