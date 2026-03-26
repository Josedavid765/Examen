<?php

namespace Src\bc\Author\Infraestructure\Traits;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Infraestructure\Models\AuthorModel;
use Src\bc\Author\Infraestructure\Hydrators\AuthorHydrators;

trait CreateAuthorTrait
{
    public function createAuthor(Author $author): void
    {
        $data = AuthorHydrators::toDatabase($author);

        AuthorModel::create($data);
    }
}
