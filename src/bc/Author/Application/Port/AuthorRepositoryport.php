<?php

namespace Src\bc\Author\Application\Port;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;

interface AuthorRepositoryport
{
    public function createAuthor(Author $author): void;

    public function readAuthor(AuthorIdValueObject $id): ?Author;

    public function updateAuthor(Author $author): void ; 

    public function deleteAuthor(AuthorIdValueObject $id): void;

    public function listAuthors() : array;
}
