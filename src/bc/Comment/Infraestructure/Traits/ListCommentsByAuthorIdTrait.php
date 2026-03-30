<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Infraestructure\Models\CommentModel;
use Src\bc\Comment\Infraestructure\Hydrator\CommentHydrator;
trait ListCommentsByAuthorIdTrait
{
    public function listCommentsByAuthorId(string $authorId): array
    {
        return CommentModel::where('author_id', $authorId)
            ->get()
            ->map(fn($model) => CommentHydrator::toDomain($model))
            ->toArray();
    }
}
