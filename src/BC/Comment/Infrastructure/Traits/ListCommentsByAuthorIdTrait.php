<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;
trait ListCommentsByAuthorIdTrait
{
    public function listCommentsByAuthorId(\Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject $authorId): array
    {
        return CommentModel::where('author_id', $authorId->value())
            ->get()
            ->map(fn($model) => CommentHydrator::toDomain($model))
            ->toArray();
    }
}
