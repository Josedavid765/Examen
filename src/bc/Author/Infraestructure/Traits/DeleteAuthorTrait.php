<?php

namespace Src\bc\Author\Infraestructure\Traits;

use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Infraestructure\Models\AuthorModel;

trait DeleteAuthorTrait
{
    public function deleteAuthor(AuthorIdValueObject $id): void
    {
        AuthorModel::destroy($id->value());
    }
}
