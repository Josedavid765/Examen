<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Post\Infrastructure\Hydrators\PostHydrator;

trait ListPostsTrait
{
    public function listPosts(): array
    {
        $postModels = PostModel::all();
        $posts = [];

        foreach ($postModels as $model) {
            $posts[] = PostHydrator::toDomain($model);
        }

        return $posts;
    }
}
