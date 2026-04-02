<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;

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