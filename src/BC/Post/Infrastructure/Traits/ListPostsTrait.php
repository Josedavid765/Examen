<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Infrastructure\Models\PostModel;
use Src\BC\Post\Infrastructure\Hydrators\PostHydrator;

trait ListPostsTrait
{
    public function listPosts(string $order='publishDate', string $direction='asc',int $page=1, int $perPage=10): array
    {
        $query = PostModel::query();

        $query->orderBy($order, $direction);

        $paginator = $query->paginate(perPage: $perPage, page: $page);

        return [
            'items' => array_map(
                fn($model) => PostHydrator::toDomain($model),
                $paginator->items()
            ),
            'pagination' => [
                'total'         => $paginator->total(),
                'perPage'       => $paginator->perPage(),
                'currentPage'   => $paginator->currentPage(),
                'lastPage'      => $paginator->lastPage(),
            ]
        ];
    }
}
