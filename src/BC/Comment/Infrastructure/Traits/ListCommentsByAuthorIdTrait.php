<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;
trait ListCommentsByAuthorIdTrait
{
    public function listCommentsByAuthorId(string $authorId, string $order = 'commentDate', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {   
        $query = CommentModel::with('author')->where('author_id', $authorId);

        $query->orderBy($order, $direction);

        $paginator = $query->paginate(perPage: $perPage, page: $page);

        return [
            'items' => array_map(
                fn($model) => CommentHydrator::toDomain($model),
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
