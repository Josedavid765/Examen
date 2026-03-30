<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Infraestructure\Models\CommentModel;
use Src\bc\Comment\Infraestructure\Hydrator\CommentHydrator;

trait ListCommentsByPostIdTrait
{
    public function listByPostId(string $postId): array
    {
        return CommentModel::where('post_id', $postId)
            ->get()
            ->map(fn($model) => CommentHydrator::toDomain($model))
            ->toArray();
    }
}