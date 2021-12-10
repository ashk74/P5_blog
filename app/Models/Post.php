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
        return $this->selectQuery("
                SELECT * FROM tag
                INNER JOIN post_tag ON post_tag.tag_id = tag.id
                WHERE post_tag.post_id = ?
            ", [$this->id]);
    }

    public function create(array $data, ?array $relations = null)
    {
        parent::create($data, $relations);

        $id = $this->pdo->lastInsertId();

        foreach($relations as $tagId) {
            $stmt = $this->pdo->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }

        return true;
    }

    public function update(int $id, array $data, ?array $relations = null)
    {
        parent::update($id, $data);

        $stmt = $this->pdo->prepare("DELETE FROM post_tag WHERE post_id = ?");
        $result = $stmt->execute([$id]);

        foreach($relations as $tagId) {
            $stmt = $this->pdo->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }

        if ($result) {
            return true;
        }
    }
}
