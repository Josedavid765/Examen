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
        $model = AuthorModel::where('email', $email->value())->first();

        if ($model && \Illuminate\Support\Facades\Hash::check($password->value(), $model->password)) {
            return AuthorHydrators::toDomain($model);
        }

        return null;
    }
}