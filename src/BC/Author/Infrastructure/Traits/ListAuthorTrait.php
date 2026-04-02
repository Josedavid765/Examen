<?php

namespace Src\BC\Author\Infrastructure\Traits;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait ListAuthorTrait
{
    public function listAuthors(): array
    {
        return AuthorModel::all()
            ->map(fn($model) => AuthorHydrators::toDomain($model))
            ->toArray();
    }
}
