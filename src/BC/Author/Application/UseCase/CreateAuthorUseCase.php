<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\DTO\AuthorDTO;
use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Illuminate\Support\Facades\Hash;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;

class CreateAuthorUseCase
{
    public function __construct(private AuthorRepositoryPort $repo) {}

    public function execute(AuthorDTO $dto): Author
    {
        $id = new AuthorIdValueObject($dto->getId());
        $firstName = new AuthorFirstNameValueObject($dto->getFirstName());
        $lastName = new AuthorLastNameValueObject($dto->getLastName());
        $birthDate = new AuthorBirthDateValueObject($dto->getBirthDate());
        $email = new AuthorEmailValueObject($dto->getEmail());
        
        $passwordPlana = $dto->getPassword();

        $pepper = config('auth.pepper');

        $passwordHasheada = Hash::make($passwordPlana . $pepper);

        $password = new AuthorPasswordValueObject($passwordHasheada);

        $author = new Author($id, $firstName, $lastName, $birthDate, $email, $password);

        $this->repo->createAuthor($author);

        return $author;
    }
}
