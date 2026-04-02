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
        $postModel = PostModel::find($id->value());

        if (!$postModel) {
            return null;
        }

        return PostHydrator::toDomain($postModel);
    }
}
