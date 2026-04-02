<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Infrastructure\Models\AuthorModel;

trait DeleteAuthorTrait
{
    public function deleteAuthor(AuthorIdValueObject $id): void
    {
        AuthorModel::destroy($id->value());
    }
}
