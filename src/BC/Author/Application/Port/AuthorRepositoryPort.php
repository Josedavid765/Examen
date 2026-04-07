<?php

namespace Src\BC\Author\Application\Port;

use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;

interface AuthorRepositoryPort
{
    public function createAuthor(Author $author): void;

    public function readAuthor(AuthorIdValueObject $id): ?Author;

    public function updateAuthor(Author $author): void ; 

    public function deleteAuthor(AuthorIdValueObject $id): void;

    public function listAuthors(?string $fullName = null, int $page=1, int $perPage=10, string $order='id',  string $direction = 'asc') : array;
}
