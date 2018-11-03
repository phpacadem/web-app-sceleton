<?php

namespace Infrastructure\EntityManager;

interface EntityManagerInterface
{
    public function addEntitySupport($tableName, $entityClassName);

    public function create($ns, $data = []);

    public function deleteById($ns, $id);

    public function deleteBy($ns, array $conditions);

    public function fill($ns, $entity, $data = []);

    public function findAll($ns);

    public function findBy($ns, $conditions = []);

    public function findById($ns, int $id);

    public function getPdo(): \PDO;

    public function save($ns, EntityInterface $entity);
}