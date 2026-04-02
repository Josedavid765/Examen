<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Post\Infrastructure\Hydrators\PostHydrator;

trait FindByAuthorIdBatchTrait
{
    public function findByAuthorIdBatch(string $authorId, int $limit): array
    {
        // Buscamos los posts del autor con un límite para no saturar la memoria
        $postModels = PostModel::where('author_id', $authorId)
                                ->limit($limit)
                                ->get();

        $posts = [];

        foreach ($postModels as $model) {
            $posts[] = PostHydrator::toDomain($model);
        }

        return $posts;
    }
}
