<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\DTO\AuthorDTO;
use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Domain\ValueObject\AuthorFirstName;
use Src\bc\Author\Domain\ValueObject\AuthorLastName;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDate;
use Exception;

class UpdateAuthorUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

    public function execute(AuthorDTO $dto): Author
    {
        $id = new AuthorId($dto->getId());

        $existingAuthor = $this->repo->readAuthor($id);
        if (!$existingAuthor) {
            throw new Exception("No se puede actualizar: El autor no existe.");
        }

        $author = new Author(
            $id,
            new AuthorFirstName($dto->getFirstName()),
            new AuthorLastName($dto->getLastName()),
            new AuthorBirthDate($dto->getBirthDate())
        );

        $this->repo->updateAuthor($author);

        return $author;
    } 
}
