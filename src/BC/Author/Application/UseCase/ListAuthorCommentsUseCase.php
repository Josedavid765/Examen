<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;

class ListAuthorCommentsUseCase
{
    public function __construct(
        private AuthorRepositoryPort $authorRepo,
        private CommentRepositoryPort $commentRepo
    ) {}

    public function execute(string $authorId, 
        int $limit = 10, 
        int $offset = 0, 
        string $order = 'comment_date', 
        string $direction = 'desc'): array
    {
        $id = new AuthorIdValueObject($authorId);

        $author = $this->authorRepo->readAuthor($id);
        
        if (!$author) {
            throw new Exception("Author not found");
        }
        
        return $this->commentRepo->listCommentsByAuthorId(
            $authorId, 
            10, 
            0,  
            $order, 
            $direction
        );
    }
}
