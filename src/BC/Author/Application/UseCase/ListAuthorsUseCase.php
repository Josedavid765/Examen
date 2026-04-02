<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;

class ListAuthorsUseCase
{
    public function __construct(private AuthorRepositoryPort $repo){}

    public function execute(): array
    {
        return $this->repo->listAuthors();
    }
}
