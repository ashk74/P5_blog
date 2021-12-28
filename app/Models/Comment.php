<?php

namespace App\Models;

class Comment extends Model
{
    protected string $table = "comment";

    public int $id;
    public int $author;
    public int $post_id;
    public string $content;
    public string $last_update;
    public string $is_moderate;

    public function linkedComments(int $postId): array
    {
        return $this->selectQuery("SELECT * FROM {$this->table} WHERE post_id = ?", [$postId]);
    }

    public function listModerated(?bool $isModerate = true): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_moderate = ? ORDER BY last_update DESC";
        return $this->selectQuery($sql, [$isModerate]);
    }
}
