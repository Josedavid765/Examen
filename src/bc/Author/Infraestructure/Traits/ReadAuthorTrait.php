<?php

namespace Src\bc\Author\Infraestructure\Traits;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Infraestructure\Models\AuthorModel;
use Src\bc\Author\Infraestructure\Hydrators\AuthorHydrators;

trait ReadAuthorTrait
{
    public function readAuthor(AuthorId $id): ?Author
    {
        $model = AuthorModel::find($id->value());

        return $model ? AuthorHydrators::toDomain($model) : null;
    }
}
