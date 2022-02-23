<?php

namespace App\Model\Repository;

use PDOStatement;
use stdClass;

/**
 * Interface INewsRepository
 *
 * @package App\Model\Repository
 */
interface INewsRepository
{
    /**
     * @param string|null $order
     * @param string|null $limit
     * @param string $fields
     * @return array
     */
    public function loadAll(string $order = null, string $limit = null, string $fields = '*'): array;

    /**
     * @param int $id
     * @return stdClass
     */
    public function loadById(int $id): stdClass;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @param $values
     * @return bool|string
     */
    public function insert($values): bool|string;

    /**
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $query, array $params = []): PDOStatement;
}