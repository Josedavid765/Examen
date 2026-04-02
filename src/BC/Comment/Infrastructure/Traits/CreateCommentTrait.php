<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Domain\Entities\Comment;
use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;

trait CreateCommentTrait
{
    public function createComment(Comment $comment): void
    {
        $data = CommentHydrator::toArray($comment);
        CommentModel::create($data);
    }
}
