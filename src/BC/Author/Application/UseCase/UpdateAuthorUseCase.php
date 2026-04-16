<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\DTO\AuthorUpdateDTO;
use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Exception;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;

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
        $email = $dto->getEmail() ?? $existingAuthor->getAuthorEmailValue();
        $password = $dto->getPassword() ?? $existingAuthor->getAuthorPasswordValue();

        $author = new Author(
            $id,
            new AuthorFirstNameValueObject($firstName),
            new AuthorLastNameValueObject($lastName),
            new AuthorBirthDateValueObject($birthDate),
            new AuthorEmailValueObject($email),
            new AuthorPasswordValueObject($password)
        );

        $this->repo->updateAuthor($author);

        return $author;
    }
}