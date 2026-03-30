<?php

namespace Src\bc\Post\Infraestructure\Traits;

use Src\bc\Post\Infraestructure\Models\PostModel;

trait DeletePostsByAuthorIdTrait
{
    public function deletePostsByAuthorId(string $authorId): void
    {
        PostModel::where('author_id', $authorId)
                ->delete();
    }
}
