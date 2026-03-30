<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Domain\Entities\Author;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;
class ReadAuthorUseCase
{
    public function __construct(private AuthorRepositoryport $repo){}

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
