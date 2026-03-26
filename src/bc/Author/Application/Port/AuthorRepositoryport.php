<?php

namespace Src\bc\Author\Application\Port;

use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorId;

interface AuthorRepositoryport
{
    public function createAuthor(Author $author): void;

    public function readAuthor(AuthorId $id): ?Author;

    public function updateAuthor(Author $author): void ; 

    public function deleteAuthor(AuthorId $id): void;

    public function listAuthors() : array;
}
