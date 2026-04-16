<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Infrastructure\Models\AuthorModel;
use Src\BC\Author\Infrastructure\Hydrators\AuthorHydrators;
use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;

trait LoginAuthorTrait
{
    public function findByCredentials(
        AuthorEmailValueObject $email, 
        AuthorPasswordValueObject $password
    ): ?Author {
        $model = AuthorModel::where('email', $email->value())
                            ->where('password', $password->value())
                            ->first();

        return $model ? AuthorHydrators::toDomain($model) : null;
    }
}