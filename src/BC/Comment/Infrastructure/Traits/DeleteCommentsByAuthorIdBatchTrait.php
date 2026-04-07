<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;

trait DeleteCommentsByAuthorIdBatchTrait
{
    public function deleteCommentsByAuthorIdBatch(CommentAuthorIdValueObject $authorId, int $limit): int
    {
        $commentsToDelete = CommentModel::where('author_id', $authorId->value())
            ->limit($limit)
            ->get();

        if ($commentsToDelete->isEmpty()) {
            return 0;
        }

        $postImpact = $commentsToDelete->groupBy('post_id')
            ->map(fn($group) => $group->count());

        $ids = $commentsToDelete->pluck('id')->toArray();
        $deletedCount = CommentModel::whereIn('id', $ids)->delete();

        foreach ($postImpact as $postId => $count) {
            PostModel::where('id', $postId)->decrement('num_comments', $count);
        }

        return $deletedCount;
    }
}