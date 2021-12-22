<?php

namespace App\Models;

use DateTime;

class Comment extends Model
{
    protected string $table = "comment";

    public function fetchLinkedComments(int $postId): array
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE post_id = ?", [$postId]);
    }

    public function listModerate(?bool $isModerate = true): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_moderate = ? ORDER BY last_update DESC";
        return $this->selectQuery($sql, [$isModerate]);
    }
}
