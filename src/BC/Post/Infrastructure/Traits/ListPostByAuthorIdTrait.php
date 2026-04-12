<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Infrastructure\Hydrators\PostHydrator;
use Src\BC\Post\Infrastructure\Models\PostModel;

trait ListPostByAuthorIdTrait
{
    public function listPostsByAuthorId(string $authorId, string $order='publishDate', string $direction='asc', int $page=1, int $perPage=10): array
    {
        $query = PostModel::with('author')->where('author_id', $authorId);

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
