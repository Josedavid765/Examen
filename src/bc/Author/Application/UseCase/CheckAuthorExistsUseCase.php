<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;

class CheckAuthorExistsUseCase
{
    public function __construct(
        private AuthorRepositoryPort $repo
    ) {}

    public function execute(string $authorId): bool
    {
        $id = new AuthorIdValueObject($authorId);
        
        return $this->repo->readAuthor($id) !== null;
    }
}