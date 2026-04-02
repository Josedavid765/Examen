<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait CreateAuthorTrait
{
    public function createAuthor(Author $author): void
    {
        $data = AuthorHydrators::toDatabase($author);

        AuthorModel::create($data);
    }
}
