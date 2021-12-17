<?php

namespace App\Models;

use DateTime;

class Post extends Model
{
    protected string $table = "post";

    public function getExcerpt(): string
    {
        return substr($this->chapo, 0, 200) . '...';
    }

    public function getAuthors()
    {
        return $this->selectQuery("
                SELECT id, CONCAT(first_name, ' ' , last_name) AS fullname
                FROM user
            ");
    }
}
