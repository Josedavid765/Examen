<?php

namespace Src\BC\Author\Infrastructure\Traits;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait ListAuthorTrait
{
    public function listAuthors(?string $fullName = null, int $page = 1, int $perPage = 10): array
    {
        $query = AuthorModel::query();

        if($fullName)
        {
            $query->where(function ($q) use ($fullName)
                    {
                        $q->where('first_name', 'LIKE', "%{$fullName}%")
                          ->orWhere('last_name', 'LIKE', "%{$fullName}%");
                    });
        }

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

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
