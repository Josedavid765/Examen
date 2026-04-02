<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;

class ListAuthorCommentsUseCase
{
    public function __construct(
        private AuthorRepositoryPort $authorRepo,
        private CommentRepositoryPort $commentRepo
    ) {}

    public function execute(string $authorId): array
    {
        $id = new AuthorIdValueObject($authorId);

        $author = $this->authorRepo->readAuthor($id);
        
        if (!$author) {
            throw new Exception("Author not found");
        }
        return $this->commentRepo->listCommentsByAuthorId($id->value());
    }
}
