<?php


namespace Infrastructure\EntityManager;


use Infrastructure\Hydrator\Hydrator;
use PDO;

class EntityManager implements EntityManagerInterface
{
    public const TABLE_NAME_PARAMETER = 'tableName';
    public const ENTITY_CLASS_NAME_PARAMETER = 'entityClassName';

    protected static $entitiesDescription = [];

    /** @var PDO */
    protected $pdo;
    /** @var Hydrator */
    protected $hydrator;

    /**
     * UserManager constructor.
     * @param  PDO $pdo
     * @param Hydrator $hydrator
     */
    public function __construct(PDO $pdo, Hydrator $hydrator)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function addEntitySupport($tableName, $entityClassName)
    {
        self::$entitiesDescription[$entityClassName] = [
            self::TABLE_NAME_PARAMETER => $tableName,
            self::ENTITY_CLASS_NAME_PARAMETER => $entityClassName,
        ];
    }

    public function findAll($ns)
    {
        return $this->findBy($ns, []);
    }

    public function findBy($ns, $conditions = [])
    {
        $sql = "select * from " . $this->getTableName($ns);

        if (!empty($conditions)) {
            $conditionsArray = [];
            foreach ($conditions as $field => $value) {
                $conditionsArray[] = "{$field}=:{$field}";

            }

            $sql .= " where " . implode(' and ', $conditionsArray);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);

        $entities = [];
        while ($data = $stmt->fetch()) {
            if (empty($data)) {
                continue;
            }
            $entityClassName = $this->getEntityClasName($ns);
            /** @var EntityInterface $entity */
            $entity = new $entityClassName($data);

            $entities[$entity->getId()] = $entity;
        }
        return $entities;
    }

    protected function getTableName($ns)
    {
        if (isset(self::$entitiesDescription[$ns][self::TABLE_NAME_PARAMETER])) {
            return self::$entitiesDescription[$ns][self::TABLE_NAME_PARAMETER];
        } else {
            throw new \Exception($ns . 'is not described');
        }
    }

    protected function getEntityClasName($ns)
    {

        if (isset(self::$entitiesDescription[$ns][self::ENTITY_CLASS_NAME_PARAMETER])) {
            return self::$entitiesDescription[$ns][self::ENTITY_CLASS_NAME_PARAMETER];
        } else {
            throw new \Exception($ns . 'is not described');
        }
    }

    public function create($ns, $data = [])
    {
        return $this->hydrator->hydrate($data, $this->getEntityClasName($ns));
    }

    public function fill($ns, $entity, $data = [])
    {
        $oldData = $this->hydrator->extract($entity);
        $data = array_merge($oldData, $data);
        return $this->hydrator->hydrate($data, $this->getEntityClasName($ns));
    }

    public function findById($ns, int $id)
    {
        $entities = $this->findBy($ns, ['id' => $id]);
        return array_shift($entities) ?? null;
    }

    public function delete($ns, EntityInterface $entity)
    {
        if (!$entity->getId()) {
            return false;
        }

        $sql = "delete from " . $this->getTableName($ns) . " where id=:id ";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            'id' => $entity->getId(),
        ]);
        return $result;
    }

    public function save($ns, EntityInterface $entity)
    {
        $entityData = $this->hydrator->extract($entity);
        try {

            if ($entity->getId()) {

                unset($entityData['created_at']);
                if (isset($entityData['updated_at'])) {
                    $entityData['updated_at'] = time();
                }

                $sql = "update " . $this->getTableName($ns) . " set ";

                if (!empty($entityData)) {
                    $updateArray = [];
                    foreach ($entityData as $field => $value) {
                        if ($field == 'id') {
                            continue;
                        }
                        $updateArray[] = "{$field}=:{$field}";
                    }
                    $updateString = implode(', ', $updateArray);


                }
                $sql .= $updateString . " where id=:id";
                $stmt = $this->pdo->prepare($sql);
                $result = $stmt->execute($entityData);
                return $result;
            } else {
                $sql = "insert into " . $this->getTableName($ns) . " (%FIELDS%) values (%VALUES%);";

                unset($entityData['created_at']);
                unset($entityData['updated_at']);

                if (!empty($entityData)) {

                    $fieldsArray = [];
                    $valuesArray = [];
                    foreach ($entityData as $field => $value) {
                        $fieldsArray[] = $field;
                        $valuesArray[] = ":{$field}";
                    }
                    $fieldsString = implode(', ', $fieldsArray);
                    $valuesString = implode(', ', $valuesArray);
                    $sql = str_replace('%FIELDS%', $fieldsString, $sql);
                    $sql = str_replace('%VALUES%', $valuesString, $sql);
                    $stmt = $this->pdo->prepare($sql);
                    $result = $stmt->execute($entityData);
                    return $result;
                }
            }

        } catch (\PDOException $e) {
            return false;
        }


    }

}