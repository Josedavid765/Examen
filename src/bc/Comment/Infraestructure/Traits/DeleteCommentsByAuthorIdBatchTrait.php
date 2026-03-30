<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Infraestructure\Models\CommentModel;

trait DeleteCommentsByAuthorIdBatchTrait
{
    public function deleteCommentsByAuthorIdBatch(string $authorId, int $limit): int
    {
        return CommentModel::where('author_id', $authorId)
            ->limit($limit)
            ->delete();
    }
}
