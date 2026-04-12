<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject ;

trait ListCommentsByPostIdTrait
{
    public function listByPostID(CommentPostIdValueObject $postId, string $order = 'commentDate', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        $query = CommentModel::with('author')->where('post_id', $postId->value());

        $query->orderBy($order, $direction);

        $paginator = $query->paginate(perPage: $perPage, page: $page);

        return [
            'items' => array_map(
                fn($model) => [
                    'comment' => CommentHydrator::toDomain($model),
                    'author' => $model->relationLoaded('author') && $model->author ? \Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators::toDomain($model->author) : null
                ],
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