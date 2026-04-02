<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;

trait DeleteCommentsByPostIdTrait
{
    public function deleteCommentsByPostId(\Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject $postId): void
    {
        CommentModel::where('post_id', $postId->value())->delete();
    }
}