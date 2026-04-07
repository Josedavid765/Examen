<?php

namespace Src\BC\Author\Infrastructure\Traits;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait ListAuthorTrait
{
    public function listAuthors(?string $fullName = null, int $page = 1, int $perPage = 10, string $order='id', string $direction = 'asc'): array
    {   
        $query = AuthorModel::query();

    if (!empty($fullName)) {
        $filter = mb_strtolower($fullName, 'UTF-8');

        $query->where(function ($q) use ($filter) {
            $q->whereRaw('LOWER(first_name) LIKE ?', ["%{$filter}%"])
              ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$filter}%"]);
        });
    }

    $query->orderBy($order, $direction);

    $paginator = $query->paginate(perPage: $perPage, page: $page);

        return [
            'items' => array_map(
                fn($model) => AuthorHydrators::toDomain($model), 
                $paginator->items()
            ),
            'pagination' => [
                'total'        => $paginator->total(),
                'perPage'      => $paginator->perPage(),
                'currentPage'  => $paginator->currentPage(),
                'lastPage'     => $paginator->lastPage(),
            ]
        ];
    }
}
