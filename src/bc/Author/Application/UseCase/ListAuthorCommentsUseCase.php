<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Comment\Domain\Ports\CommentRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorId;

class ListAuthorCommentsUseCase
{
    public function __construct(
        private AuthorRepositoryport $authorRepo,
        private CommentRepositoryPort $commentRepo
    ) {}

    public function execute(string $authorId): array
    {
        $id = new AuthorId($authorId);

        $author = $this->authorRepo->readAuthor($id);
        
        if (!$author) {
            throw new \Exception("Author not found");
        }
        return $this->commentRepo->findAllByAuthorId($id->value());
    }
}
