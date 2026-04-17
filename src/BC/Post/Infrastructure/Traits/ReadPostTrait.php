<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Post\Infrastructure\Hydrators\PostHydrator;

trait ReadPostTrait
{
    public function readPost(PostIdValueObject $id): ?Post
    {
        $postModel = PostModel::query()
            ->join('authors', 'posts.author_id', '=', 'authors.id')
            ->select([
                'posts.*',
                'authors.first_name',
                'authors.last_name'
            ])
            ->where('posts.id', $id->value())
            ->first();

        if (!$postModel) {
            return null;
        }

        return PostHydrator::toDomain($postModel);
    }
}
