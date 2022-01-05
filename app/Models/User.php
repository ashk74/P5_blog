<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'user';

    public function listValidated(?bool $isValidate = true)
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_validate = ? ORDER BY registration_date DESC";
        return $this->selectQuery($sql, [$isValidate]);
    }

    public function listAdmin()
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_admin = ? ORDER BY registration_date DESC";
        return $this->selectQuery($sql, [1]);
    }

    public function findByEmail(string $email)
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }

    public function isEmailExist(string $email): bool
    {
        return $this->selectQuery("SELECT email FROM {$this->table} WHERE email = ?", [$email], true) ? true : false;
    }
}
