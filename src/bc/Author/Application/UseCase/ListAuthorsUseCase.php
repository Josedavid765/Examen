<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryPort;

class ListAuthorsUseCase
{
    public function __construct(private AuthorRepositoryPort $repo){}

    public function execute(): array
    {
        return $this->repo->listAuthors();
    }
}
