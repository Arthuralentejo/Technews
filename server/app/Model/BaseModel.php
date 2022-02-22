<?php

namespace App\Model;

use App\Utils\DBConnector;
use http\Encoding\Stream\Inflate;
use PDOException;
use PDOStatement;
use PDO;

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
     * @var PDO
     */
    protected PDO $connection;

    /**
     * @param string|null $order
     * @param string|null $limit
     * @param string $fields
     * @return array
     */
    public function loadAll(string $order = null, string $limit = null, string $fields = '*'): array
    {
        $order = strlen($order) ? 'ORDER BY '.$this->entityField." ".$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = "SELECT " . $fields . " FROM " . $this->tableName . " " . $order . " " . $limit;
        $statement = $this->execute($query);
        $news = [];
        while ($objNews = $statement->fetch(PDO::FETCH_PROPS_LATE|PDO::FETCH_OBJ)) {
            $news[] = $objNews;
        }
        return $news;
    }


    /**
     * @return integer
     */
    public function getTotal(): int
    {
        $query = 'SELECT COUNT(*) as total FROM '.$this->tableName;

        return $this->execute($query)->fetch(PDO::FETCH_ASSOC)['total'];
    }
    /**
     * @param $values
     * @return false|string
     */

    public function insert($values): bool|string
    {
        $fields = array_keys($values);
        $inter = array_map(function($field){
            return '?';
        },$fields);

        $query = 'INSERT INTO '.$this->tableName.'('.implode(',',$fields).') VALUES ('.implode(',',$inter).')';
        $this->execute($query,array_values($values));
        return $this->connection->lastInsertId();
    }
    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    private function execute(string $query, array $params = []): PDOStatement
    {
        $this->connection = DBConnector::getInstance();
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }
}