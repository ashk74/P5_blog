<?php

namespace App\Models;

use DateTime;

class Post extends Model
{
    protected string $table = "post";

    public function getLastUpdate(?bool $withTime = false): string
    {
        $dateFormat = 'd/m/Y';

        if ($withTime) {
            $dateFormat .= ' à H\hi';
        }

        return $date = (new DateTime(($this->last_update)))->format($dateFormat);
    }

    public function getExcerpt(): string
    {
        return substr($this->chapo, 0, 200) . '...';
    }

    public function getTags()
    {
        return $this->query("
                SELECT * FROM tag
                INNER JOIN post_tag ON post_tag.tag_id = tag.id
                WHERE post_tag.post_id = ?
            ", $this->id);
    }
}
