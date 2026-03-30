<?php

namespace Src\bc\Post\Infraestructure\Traits;

use Src\bc\Post\Infraestructure\Models\PostModel;
use Src\bc\Post\Infraestructure\Hydrators\PostHydrator;

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
