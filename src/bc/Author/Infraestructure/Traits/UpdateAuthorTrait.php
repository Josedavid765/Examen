<?php

namespace Src\bc\Author\Infraestructure\Traits;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Infraestructure\Models\AuthorModel;
use Src\bc\Author\Infraestructure\Hydrators\AuthorHydrators;

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
