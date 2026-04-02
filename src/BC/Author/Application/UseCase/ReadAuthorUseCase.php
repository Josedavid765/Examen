<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\Entities\Author;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;
class ReadAuthorUseCase
{
    public function __construct(private AuthorRepositoryPort $repo){}

    public function execute(string $id): Author
    {
        $authorId = new AuthorIdValueObject($id);

        $author = $this->repo->readAuthor($authorId);

        if (!$author) 
        {
            throw new Exception("Author not found"); 
        }

        return $author;
    }
}
