<?php

namespace App\Models;

class User extends Model
{
    protected string $table = 'user';

    public function getByEmail(string $email): User
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }

    public function alreadyExist(string $email): bool
    {
        return $this->selectQuery("SELECT email FROM {$this->table} WHERE email = ?", [$email], true) ? true : false;
    }
}
