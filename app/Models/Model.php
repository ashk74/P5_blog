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

    /**
     * Retrieve all items in the current table
     *
     * @param boolean|null $orderBy False by default | True if the results must be displayed by last update date
     *
     * @return array
     */
    public function all(?bool $orderBy = false): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $order = !$orderBy ? "" : " ORDER BY last_update DESC";
        $sql .= $order;
        return $this->selectQuery($sql);
    }

    public function findById(int $id): Model
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    /**
     * Dynamic select query method
     *
     * @param string $sql SQL query
     * @param integer|null $param Array of params to execute : Null by default
     * @param boolean $single True for fetch() | False or null for fetchAll()
     */
    public function selectQuery(string $sql, array $param = null, bool $single = null)
    {
        $method = is_null($param) ? 'query' : 'prepare';
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

    /**
     * Dynamic query method for update or delete
     *
     * @param string $sql
     * @param array|null $param
     *
     * @return bool
     */
    public function editQuery(string $sql, array $param = null): bool
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this));

        return $stmt->execute($param);
    }

    /**
     * Dynamic insert query method
     *
     * @param array $data
     *
     * @return void
     */
    public function create(array $data)
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

        return $this->editQuery("INSERT INTO {$this->table} ($firstParenthesis) VALUES ($secondParenthesis)", $data);
    }

    /**
     * Dynamic update query method
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function update(int $id, array $data)
    {
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? '' : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;

        return $this->editQuery("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
    }

    public function delete(int $id): bool
    {
        return $this->editQuery("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function getAuthor(int $id)
    {
        return $this->selectQuery("
                SELECT CONCAT(first_name, ' ' , last_name) AS fullname
                FROM user
                WHERE user.id = ?
            ", [$id]);
    }

    public function getEmail(int $id): object
    {
        return $this->selectQuery("SELECT email FROM user WHERE id = ?", [$id], true);
    }
}
