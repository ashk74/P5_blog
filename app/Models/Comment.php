<?php

namespace App\Models;

use DateTime;

class Comment extends Model
{
    protected string $table = "comment";

    public function fetchLinkedComments(int $postId): array
    {
        return $this->selectQuery("SELECT * FROM comment WHERE post_id = ?", [$postId]);
    }
}
