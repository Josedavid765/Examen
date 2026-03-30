<?php

namespace Src\bc\Post\Infraestructure\Hydrators;

use Src\bc\Post\Infraestructure\Models\PostModel;
use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\bc\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\bc\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\bc\Post\Domain\ValueObject\PostStatusValueObject;
use Src\bc\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostCommentCount;

class PostHydrator
{
    public static function toDomain(PostModel $model): Post
    {
        return new Post(
            new PostIdValueObject($model->id),
            new PostSubjectValueObject($model->subject),
            new PostDescriptionValueObject($model->description),
            new PostPublishDateValueObject($model->publish_date),
            new PostStatusValueObject($model->status),
            new PostAuthorIdValueObject($model->author_id),
            new PostCommentCount((int)$model->num_comments)
        );
    }
}
