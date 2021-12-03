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
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY last_update DESC");
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        
        return $stmt->fetchAll();
    }

    public function findById(int $id): Model
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}