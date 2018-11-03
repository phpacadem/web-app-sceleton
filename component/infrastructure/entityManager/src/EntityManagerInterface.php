<?php

namespace Infrastructure\EntityManager;

interface EntityManagerInterface
{
    public function addEntitySupport($tableName, $entityClassName);

    public function findAll($ns);

    public function findBy($ns, $conditions = []);

    public function fill($ns, $entity, $data = []);

    public function create($ns, $data = []);

    public function findById($ns, int $id);

    public function delete($ns, EntityInterface $entity);

    public function save($ns, EntityInterface $entity);

    public function getPdo(): \PDO;
}