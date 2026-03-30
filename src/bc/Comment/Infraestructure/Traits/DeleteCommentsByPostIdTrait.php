<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Infraestructure\Models\CommentModel;

trait DeleteCommentsByPostIdTrait
{
    public function deleteCommentsByPostId(string $postId): void
    {
        CommentModel::where('post_id', $postId)->delete();
    }
}