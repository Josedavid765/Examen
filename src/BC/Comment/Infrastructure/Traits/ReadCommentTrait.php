<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Domain\Entities\Comment;
use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;

trait ReadCommentTrait
{
    public function readComment(\Src\BC\Comment\Domain\ValueObject\CommentIdValueObject $id): ?Comment
    {
        $model = CommentModel::find($id->value());
        return $model ? CommentHydrator::toDomain($model) : null;
    }
}
