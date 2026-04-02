<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;

trait DeleteCommentTrait
{
    public function deleteComment(\Src\BC\Comment\Domain\ValueObject\CommentIdValueObject $id): void
    {
        CommentModel::destroy($id->value());
    }
}
