<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;

trait ListCommentsByAuthorIdTrait
{
    public function listCommentsByAuthorId(
        string $authorId,
        int $limit = 10,
        int $offset = 0,
        string $order = 'comment_date',
        string $direction = 'desc'
    ): array {   
        
        $query = CommentModel::where('author_id', $authorId);

        $column = ($order === 'id') ? 'id' : $order;
        $query->orderBy($column, $direction);

        $page = ($limit > 0) ? ($offset / $limit) + 1 : 1;

        $paginator = $query->paginate(perPage: $limit, page: $page);

        return [
            'items' => array_map(
                fn($model) => CommentHydrator::toDomain($model),
                $paginator->items()
            ),
            'meta' => [
                'total'         => $paginator->total(),
                'perPage'       => $paginator->perPage(),
                'currentPage'   => $paginator->currentPage(),
                'lastPage'      => $paginator->lastPage(),
            ]
        ];
    }
}