<?php

namespace Src\bc\Comment\Infraestructure\Traits;

use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Infraestructure\Models\CommentModel;
use Src\bc\Comment\Infraestructure\Hydrator\CommentHydrator;

trait ReadCommentTrait
{
    public function readComment(string $id): ?Comment
    {
        $model = CommentModel::find($id);
        return $model ? CommentHydrator::toDomain($model) : null;
    }
}
