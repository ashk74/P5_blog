<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'user';

    public function listValidate(?bool $isValidate = true): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_validate = ? ORDER BY registration_date DESC";
        return $this->selectQuery($sql, [$isValidate]);
    }

    public function listAdmin(): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_admin = ? ORDER BY registration_date DESC";
        return $this->selectQuery($sql, [1]);
    }

    public function getByEmail(string $email)
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }

    public function emailExist(string $email): bool
    {
        return $this->selectQuery("SELECT email FROM {$this->table} WHERE email = ?", [$email], true) ? true : false;
    }
}
