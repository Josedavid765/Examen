<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\DTO\AuthorUpdateDTO;
use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Exception;

class UpdateAuthorUseCase
{
    public function __construct(private AuthorRepositoryPort $repo){}

    public function execute(AuthorUpdateDTO $dto): Author
    {
        $id  = new AuthorIdValueObject($dto->getId());

        $existingAuthor = $this->repo->readAuthor($id);
        if (!$existingAuthor) {
            throw new Exception("No se puede actualizar: El autor no existe.");
        }

        $firstName = $dto->getFirstName() ?? $existingAuthor->getAuthorFirstNameValue();
        $lastName = $dto->getLastName() ?? $existingAuthor->getAuthorLastNameValue();
        $birthDate = $dto->getBirthDate() ?? $existingAuthor->getAuthorBirthDateValue();

        $author = new Author(
            $id,
            new AuthorFirstNameValueObject($firstName),
            new AuthorLastNameValueObject($lastName),
            new AuthorBirthDateValueObject($birthDate)
        );

        $this->repo->updateAuthor($author);

        return $author;
    }
}