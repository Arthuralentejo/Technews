<?php

namespace App\Model;

use App\Utils\DBConnector;
use Exception;
use PDOException;
use PDOStatement;
use PDO;
use stdClass;

/**
 *
 */
abstract class BaseModel
{
    /**
     * @var string
     */
    protected string $entityField = 'id';
    /**
     * @var string
     */
    protected string $tableName = '';
    /**
     * @var array
     */
    protected array $fields = [];

    /**
     * @param string|null $order
     * @param string|null $limit
     * @param string $fields
     * @return array
     */
    public function loadAll(string $order = null, string $limit = null, string $fields = '*'): array
    {
        $order = strlen($order) ? 'ORDER BY ' . $this->entityField . " " . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = "SELECT " . implode(',', $this->fields) . " FROM " . $this->tableName . " " . $order . " " . $limit;
        $statement = $this->execute($query);
        $news = [];
        while ($objNews = $statement->fetch(PDO::FETCH_PROPS_LATE | PDO::FETCH_OBJ)) {
            $news[] = $objNews;
        }
        return $news;
    }

    /**
     * @param int $id
     * @return stdClass
     * @throws Exception
     */
    public function loadById(int $id): stdClass
    {
        if (!isset($id)) {
            throw new Exception("Noticia não encontrada");
        }
        $query = "SELECT " . implode(',', $this->fields) . " FROM " . $this->tableName . " WHERE id = " . $id;
        $statement = $this->execute($query);
        return $statement->fetch(PDO::FETCH_PROPS_LATE | PDO::FETCH_OBJ);
    }

    /**
     * @return integer
     */
    public function getTotal(): int
    {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->tableName;

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * @param $values
     * @return false|string
     */

    public function insert($values): bool|string
    {
        $fields = array_keys($values);
        $inter = array_map(function ($field) {
            return '?';
        }, $fields);

        $query = 'INSERT INTO ' . $this->tableName . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $inter) . ')';
        $this->execute($query, array_values($values));
        return DBConnector::getInstance()->lastInsertId();
    }

    /**
     * @param $id
     * @param $values
     * @return bool
     */
    public function update($id, $values): bool
    {
        $fields = array_keys($values);
        $query = 'UPDATE ' . $this->tableName . ' SET ' . implode('= ?,', $fields) . '= ? WHERE ' . $this->entityField . ' = ' . $id;
        $this->execute($query, array_values($values));
        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $query = 'DELETE FROM ' . $this->tableName . ' WHERE ' . $this->entityField . ' = ' . $id;
        $this->execute($query);
        return true;
    }

    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    private function execute(string $query, array $params = []): PDOStatement
    {
        $connection = DBConnector::getInstance();
        try {
            $statement = $connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            throw new PDOException('ERROR: ' . $e->getMessage());
        }
    }
}