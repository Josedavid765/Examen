<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Infrastructure\Models\PostModel;

trait DeletePostsByAuthorIdTrait
{
    public function deletePostsByAuthorId(string $authorId): void
    {
        PostModel::where('author_id', $authorId)
                ->delete();
    }
}
