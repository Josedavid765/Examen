<?php

namespace Src\BC\Author\Infrastructure\Hydrators;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;
use Src\BC\Author\Infrastructure\Models\AuthorModel;

class AuthorHydrators
{
    public static function toDomain(AuthorModel $model): Author
    {
        return new Author(
            new AuthorIdValueObject((string) $model->id),
            new AuthorFirstNameValueObject((string) $model->first_name),
            new AuthorLastNameValueObject((string) $model->last_name),
            new AuthorBirthDateValueObject((string) $model->birth_date),
            new AuthorEmailValueObject((string)$model->email),
            new AuthorPasswordValueObject((string)($model->password))
        );
    }

    public static function toDatabase(Author $author): array
    {
        return [
            'id' => $author->getAuthorIdValue(),
            'first_name' => $author->getAuthorFirstNameValue(),
            'last_name' => $author->getAuthorLastNameValue(),
            'birth_date' => $author->getAuthorBirthDateValue(),
            'email'      => $author->getAuthorEmailValue(),
            'password'   => $author->getAuthorPasswordValue(),
        ];
    }
}
