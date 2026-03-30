<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\DTO\AuthorDTO;
use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Exception;

class UpdateAuthorUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

    public function execute(AuthorDTO $dto): Author
    {
        $id = new AuthorIdValueObject($dto->getId());

        $existingAuthor = $this->repo->readAuthor($id);
        if (!$existingAuthor) {
            throw new Exception("No se puede actualizar: El autor no existe.");
        }

        $author = new Author(
            $id,
            new AuthorFirstNameValueObject($dto->getFirstName()),
            new AuthorLastNameValueObject($dto->getLastName()),
            new AuthorBirthDateValueObject($dto->getBirthDate())
        );

        $this->repo->updateAuthor($author);

        return $author;
    } 
}
