<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
trait DeleteCommentsByPostIdTrait
{
    public function deleteCommentsByPostId(string $postId): void
    {
        CommentModel::where('post_id', $postId)->delete();
    }
}