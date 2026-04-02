<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;
class ListAuthorPostsUseCase
{
    public function __construct(
        private AuthorRepositoryPort $authorRepo,
        private PostRepositoryPort $postRepo
    ) {}

    public function execute(string $authorId): array
    {
        $id = new AuthorIdValueObject($authorId);

        if (!$this->authorRepo->readAuthor($id)) {
            throw new Exception("Author not found");
        }

        return $this->postRepo->findByAuthorIdBatch($id->value(), 100);
    }
}