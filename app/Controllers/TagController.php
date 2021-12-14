<?php

namespace App\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function tag(int $id)
    {
        $tag = (new Tag())->findById($id);

        $this->twig->display('blog/tag.twig', [
            'tag' => $tag
        ]);
    }
}
