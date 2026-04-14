<?php

namespace Src\BC\Comment\Infrastructure\Traits;

use Src\BC\Comment\Infrastructure\Models\CommentModel;
use Src\BC\Comment\Infrastructure\Hydrator\CommentHydrator;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Illuminate\Support\Facades\DB;

trait ListCommentsByPostIdTrait
{
    public function listByPostID(CommentPostIdValueObject $postId, string $order = 'comment_date', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        $query = CommentModel::query()
            ->leftJoin('authors', 'comments.author_id', '=', 'authors.id')
            ->select([
                'comments.*',
                DB::raw("CONCAT_WS(' ', authors.first_name, authors.last_name) as author_fullname")
            ])
            ->where('post_id', $postId->value());

        $column = ($order === 'id') ? 'comments.id' : "comments.{$order}";
        $query->orderBy($column, $direction);

        $paginator = $query->paginate(perPage: $perPage, page: $page);

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