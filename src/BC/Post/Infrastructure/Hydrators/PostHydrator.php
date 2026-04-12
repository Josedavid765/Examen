<?php

namespace Src\BC\Post\Infrastructure\Hydrators;

use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\BC\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\BC\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\BC\Post\Domain\ValueObject\PostStatusValueObject;
use Src\BC\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostCommentCount;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

class PostHydrator
{
    public static function toDomain(PostModel $model): Post
    {
        $author = null;
        if ($model->relationLoaded('author') && $model->author) {
            $author = AuthorHydrators::toDomain($model->author);
        }

        return new Post(
            new PostIdValueObject($model->id),
            new PostSubjectValueObject($model->subject),
            new PostDescriptionValueObject($model->description),
            new PostPublishDateValueObject($model->publish_date),
            new PostStatusValueObject($model->status),
            new PostAuthorIdValueObject($model->author_id),
            new PostCommentCount((int)$model->num_comments),
            $author
        );
    }
}
