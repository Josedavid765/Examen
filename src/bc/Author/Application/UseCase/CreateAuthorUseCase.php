<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\DTO\AuthorDTO;
use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorFirstName;
use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Domain\ValueObject\AuthorLastName;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDate;

class CreateAuthorUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

    public function execute(AuthorDTO $dto): Author
    {
        $id = new AuthorId($dto->getId());
        $firstName = new AuthorFirstName($dto->getFirstName());
        $lastName = new AuthorLastName($dto->getLastName());
        $birthDate = new AuthorBirthDate($dto->getBirthDate());

        $author = new Author($id, $firstName, $lastName, $birthDate);

        $this->repo->createAuthor($author);

        return $author;
    }
}
