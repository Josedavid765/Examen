<?php

namespace Src\bc\Comment\Infraestructure\Hydrator;

use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentStatusValueObject;
use Src\bc\Comment\Infraestructure\Models\CommentModel;

class CommentHydrator
{
    public static function toDomain(CommentModel $model): Comment
    {
        return new Comment(
            new CommentIdValueObject($model->id),
            new CommentDescriptionValueObject($model->description),
            new CommentAuthorIdValueObject($model->author_id),
            new CommentStatusValueObject($model->status),
            new CommentPostIdValueObject($model->post_id),
            new CommentDateValueObject($model->comment_date)
        );
    }

    public static function toArray(Comment $entity): array
    {
        return [
            'id' => $entity->getCommentIdValue(),
            'description' => $entity->getDescriptionValue(),
            'author_id' => $entity->getAuthorIdValue(),
            'status' => $entity->getStatusValue(),
            'post_id' => $entity->getPostIdValue(),
            'comment_date' => $entity->getCommentDateValue(),
        ];
    }
}
