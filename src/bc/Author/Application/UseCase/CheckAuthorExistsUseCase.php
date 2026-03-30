<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;

class CheckAuthorExistsUseCase
{
    public function __construct(
        private AuthorRepositoryport $repo
    ) {}

    public function execute(string $authorId): bool
    {
        $id = new AuthorIdValueObject($authorId);
        
        return $this->repo->readAuthor($id) !== null;
    }
}