<?php

namespace Src\bc\Author\Infraestructure\Hydrators;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Src\bc\Author\Infraestructure\Models\AuthorModel;

class AuthorHydrators
{
    public static function toDomain(AuthorModel $model): Author
    {
        return new Author(
            new AuthorIdValueObject((string) $model->id),
            new AuthorFirstNameValueObject((string) $model->first_name),
            new AuthorLastNameValueObject((string) $model->last_name),
            new AuthorBirthDateValueObject((string) $model->birth_date)
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
