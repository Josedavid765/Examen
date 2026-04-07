<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;

trait DeleteCommentTrait
{
    public function deleteComment(CommentIdValueObject $id): void
    {
        CommentModel::destroy($id->value());
    }
}
