<?php

namespace Src\bc\Author\Infraestructure\Traits;

use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Infraestructure\Models\AuthorModel;

trait DeleteAuthorTrait
{
    public function deleteAuthor(AuthorId $id): void
    {
        AuthorModel::destroy($id->value());
    }
}
