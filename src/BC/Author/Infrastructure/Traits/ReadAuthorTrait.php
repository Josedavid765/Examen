<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait ReadAuthorTrait
{
    public function readAuthor(AuthorIdValueObject $id): ?Author
    {
        $model = AuthorModel::find($id->value());

        return $model ? AuthorHydrators::toDomain($model) : null;
    }
}