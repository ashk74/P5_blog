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

    public function all(?bool $orderBy = false): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $order = !$orderBy ? "" : " ORDER BY last_update DESC";
        $sql .= $order;
        return $this->query($sql);
    }

    public function findById(int $id): Model
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    /**
     * Refactoring query for fetch() or fetchAll()
     *
     * @param string $sql SQL query
     * @param integer|null $param Param to execute
     * @param boolean $single True for fetch() | False for fetchAll()
     */
    public function query(string $sql, array $param = null, bool $single = null)
    {
        $method = is_null($param) ? 'query' : 'prepare';

        if (strpos($sql, 'DELETE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'INSERT') === 0) {
            $stmt = $this->pdo->$method($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = $this->pdo->$method($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

        if ($method === 'query') {
           return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }

    public function create(array $data, ?array $relations = null)
    {
        $firstParenthesis = "";
        $secondParenthesis = "";
        $i = 1;
        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $firstParenthesis .= "{$key}{$comma}";
            $secondParenthesis .= ":{$key}{$comma}";
            $i++;
        }

        return $this->query("INSERT INTO {$this->table} ($firstParenthesis) VALUES ($secondParenthesis)", $data);
    }

    public function update(int $id, array $data, ?array $relations = null)
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? '' : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;
        // TODO Fatal error: Uncaught PDOException: SQLSTATE[42000]: Syntax error or access violation: 1064 Erreur de syntaxe près de 'WHERE id = '3'' à la ligne 1 in C:\wamp64\www\P5_blog\app\Models\Model.php on line 54
        // Video : Editer les articles
        return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
    }

    public function delete(int $id): bool
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
}
