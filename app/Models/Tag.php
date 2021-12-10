<?php

namespace App\Models;

class Tag extends Model
{
    protected string $table = "tag";

    public function getPosts()
    {
        return $this->selectQuery("
            SELECT * from post
            INNER JOIN post_tag ON post_tag.post_id = post.id
            WHERE post_tag.tag_id = ?
        ", [$this->id]);
    }
}
