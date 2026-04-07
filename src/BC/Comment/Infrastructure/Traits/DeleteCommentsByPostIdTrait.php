<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;


trait DeleteCommentsByPostIdTrait
{
    public function deleteCommentsByPostId(CommentPostIdValueObject $postId): void
    {
        CommentModel::where('post_id', $postId->value())->delete();
    }
}