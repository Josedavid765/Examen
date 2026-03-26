<?php

namespace Src\bc\Author\Infraestructure\Hydrators;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Domain\ValueObject\AuthorFirstName;
use Src\bc\Author\Domain\ValueObject\AuthorLastName;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDate;
use Src\bc\Author\Infraestructure\Models\AuthorModel;

class AuthorHydrators
{
    public static function toDomain(AuthorModel $model): Author
    {
        return new Author(
            new AuthorId($model->id),
            new AuthorFirstName($model->first_name),
            new AuthorLastName($model->last_name),
            new AuthorBirthDate($model->birth_date)
        );
    }

    public static function toDatabase(Author $author): array
    {
        return [
            'id' => $author->getAuthorIdValue(),
            'first_name' => $author->getAuthorFirstNameValue(),
            'last_name' => $author->getAuthorLastNameValue(),
            'birth_date' => $author->getAuthorBirthDateValue(),
        ];
    }
}
