<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Infraestructure\Models\CommentModel;
use Src\bc\Comment\Infraestructure\Hydrator\CommentHydrator;
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
