<?php

namespace App\Models;

use PDO;
use Database\Database;

abstract class Model
{
    /**
     * @var PDO Contains the connection to the database
     */
    protected PDO $pdo;

    /**
     * @var string $table Name of the table containing the data to fetch
     */
    protected string $table;

    /**
     * Initialize the database connection
     */
    public function __construct()
    {
        $this->pdo = Database::dbConnect();
    }

    public function all(): array
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY last_update DESC");
    }

    public function findById(int $id): Model
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", $id, true);
    }

    /**
     * Refactoring query for fetch() or fetchAll()
     *
     * @param string $sql SQL query
     * @param integer|null $param Param to execute
     * @param boolean $single True for fetch() | False for fetchAll()
     */
    public function query(string $sql, int $param = null, bool $single = false)
    {
        $method = is_null($param) ? 'query' : 'prepare';
        $fetch = !$single ? 'fetchAll' : 'fetch';

        $stmt = $this->pdo->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

        if ($method === 'query') {
           return $stmt->$fetch();
        } else {
            $stmt->execute([$param]);
            return $stmt->$fetch();
        }
    }
}
