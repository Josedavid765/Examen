<?php

namespace Src\bc\Author\Infraestructure\Traits;
use Src\bc\Author\Infraestructure\Models\AuthorModel;
use Src\bc\Author\Infraestructure\Hydrators\AuthorHydrators;

trait ListAuthorTrait
{
    public function listAuthors(): array
    {
        return AuthorModel::all()
            ->map(fn($model) => AuthorHydrators::toDomain($model))
            ->toArray();
    }
}
