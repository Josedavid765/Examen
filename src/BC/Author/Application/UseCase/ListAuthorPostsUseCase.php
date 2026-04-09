<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Exception;
class ListAuthorPostsUseCase
{
    public function __construct(
        private AuthorRepositoryPort $authorRepo,
        private PostRepositoryPort $postRepo
    ) {}

    public function execute(string $authorId,  string $order='publishDate', string $direction='asc', int $page=1, int $perPage=10): array
    {
        $id = new AuthorIdValueObject($authorId);

        if (!$this->authorRepo->readAuthor($id)) {
            throw new Exception("Author not found");
        }

        return $this->postRepo->listPostsByAuthorId($id->value(), $order, $direction, $page, $perPage);
    }
}