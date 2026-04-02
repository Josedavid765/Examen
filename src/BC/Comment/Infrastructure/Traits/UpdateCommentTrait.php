<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Domain\Entities\Comment;
use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;
trait UpdateCommentTrait
{
    public function updateComment(Comment $comment): void
    {
        $model = CommentModel::find($comment->getCommentIdValue());
        
        if ($model) {
            $model->update(CommentHydrator::toArray($comment));
        }
    }
}
