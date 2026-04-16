<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;

class LoginAuthorUseCase
{
    public function __construct(private AuthorRepositoryPort $repository) {}

    public function execute(
        AuthorEmailValueObject $email, 
        AuthorPasswordValueObject $password
    ): ?Author {
        return $this->repository->findByCredentials($email, $password);
    }
}