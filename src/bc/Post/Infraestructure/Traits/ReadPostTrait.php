<?php

namespace Src\bc\Post\Infraestructure\Traits;

use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Src\bc\Post\Infraestructure\Models\PostModel;
use Src\bc\Post\Infraestructure\Hydrators\PostHydrator;

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
