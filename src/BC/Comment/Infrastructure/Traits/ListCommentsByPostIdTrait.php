<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;

trait ListCommentsByPostIdTrait
{
    public function listByPostID(\Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject $postId): array
    {
        return CommentModel::where('post_id', $postId->value())
            ->get()
            ->map(fn($model) => CommentHydrator::toDomain($model))
            ->toArray();
    }
}