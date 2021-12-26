<?php

namespace App\Models;

class Comment extends Model
{
    protected string $table = "comment";

    public function linkedComments(int $postId): array
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE post_id = ?", [$postId]);
    }

    public function listModerate(?bool $isModerate = true): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_moderate = ? ORDER BY last_update DESC";
        return $this->selectQuery($sql, [$isModerate]);
    }
}
