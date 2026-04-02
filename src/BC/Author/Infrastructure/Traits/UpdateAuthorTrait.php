<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;

trait UpdateAuthorTrait
{
    public function updateAuthor(Author $author): void
    {
        $model = AuthorModel::find($author->getAuthorIdValue());

        if ($model) {
            $model->update(AuthorHydrators::toDatabase($author));
        }
    }
}
