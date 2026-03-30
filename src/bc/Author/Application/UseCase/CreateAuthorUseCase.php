<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\DTO\AuthorDTO;
use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDateValueObject;

class CreateAuthorUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

    public function execute(AuthorDTO $dto): Author
    {
        $id = new AuthorIdValueObject($dto->getId());
        $firstName = new AuthorFirstNameValueObject($dto->getFirstName());
        $lastName = new AuthorLastNameValueObject($dto->getLastName());
        $birthDate = new AuthorBirthDateValueObject($dto->getBirthDate());

        $author = new Author($id, $firstName, $lastName, $birthDate);

        $this->repo->createAuthor($author);

        return $author;
    }
}
