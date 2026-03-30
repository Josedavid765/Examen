<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Infraestructure\Models\CommentModel;

trait DeleteCommentTrait
{
    public function deleteComment(string $id): void
    {
        CommentModel::destroy($id);
    }
}
