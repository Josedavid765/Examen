<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;

class ListAuthorsUseCase
{
    public function __construct(private AuthorRepositoryPort $repo){}

    public function execute(?string $fullName = null, int $page = 1, int $perPage = 10, string $column='id', string $direction = 'asc'): array
    {
        return $this->repo->listAuthors($fullName, $page, $perPage, $column, $direction);
    }
}
