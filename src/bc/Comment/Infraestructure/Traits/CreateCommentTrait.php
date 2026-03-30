<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Infraestructure\Models\CommentModel;
use Src\bc\Comment\Infraestructure\Hydrator\CommentHydrator;

trait CreateCommentTrait
{
    public function createComment(Comment $comment): void
    {
        $data = CommentHydrator::toArray($comment);
        CommentModel::create($data);
    }
}
