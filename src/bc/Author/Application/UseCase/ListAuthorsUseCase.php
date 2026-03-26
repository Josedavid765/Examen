<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;

class ListAuthorsUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

    public function execute(): array
    {
        return $this->repo->listAuthors();
    }
}
