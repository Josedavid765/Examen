<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Post\Domain\Ports\PostRepositoryPort;  
use Src\bc\Author\Domain\ValueObject\AuthorId;

class ListAuthorPostsUseCase
{
    public function __construct(
        private AuthorRepositoryport $authorRepo,
        private PostRepositoryPort $postRepo
    ) {}

    public function execute(string $authorId): array
    {
        $id = new AuthorId($authorId);
        if (!$this->authorRepo->readAuthor($id)) {
            throw new \Exception("Author not found");
        }
        return $this->postRepo->findAllByAuthorId($id->value());
    }
}
