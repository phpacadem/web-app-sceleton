<?php


namespace Blog;


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

}