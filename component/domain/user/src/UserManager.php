<?php

namespace PhpAcadem\domain\User;


use PDO;

class UserManager
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

    public function getById(int $id): ?UserInterface
    {
        $stmt = $this->pdo->prepare("select * from user where id=:id");
        $stmt->execute([
            'id' => $id
        ]);

        $userData = $stmt->fetch();
        if (empty($userData)) {
            return null;
        }

        return new User($userData);
    }

    public function getByLogin(string $login): ?UserInterface
    {
        $stmt = $this->pdo->prepare("select * from user where login=:login");
        $stmt->execute([
            'login' => $login
        ]);

        $postData = $stmt->fetch();
        if (empty($postData)) {
            return null;
        }

        return new User($postData);
    }

    public function create($login, $password, $roles = [])
    {
        $stmt = $this->pdo->prepare("insert into user (name, login, roles, password_hash) values('', :login, :roles, :password_hash)");
        return $stmt->execute([
            'login' => $login,
            'roles' => json_encode($roles),
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

}