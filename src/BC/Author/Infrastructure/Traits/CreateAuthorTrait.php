<?php

namespace Src\BC\Author\Infrastructure\Traits;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Infrastructure\Models\AuthorModel;

trait CreateAuthorTrait
{
    public function createAuthor(Author $author): void
    {
        AuthorModel::create([
            'id'         => $author->getAuthorIdValue(),
            'first_name' => $author->getAuthorFirstNameValue(),
            'last_name'  => $author->getAuthorLastNameValue(),
            'birth_date' => $author->getAuthorBirthDateValue(),
            'email'      => $author->getAuthorEmailValue(),
            'password'   => \Illuminate\Support\Facades\Hash::make($author->getAuthorPasswordValue()),
        ]);
    }
}