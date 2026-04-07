<?php

namespace Src\BC\Author\Application\UseCase;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class DeleteAuthorUseCase
{
    public function __construct(
        private AuthorRepositoryPort $repo,
        private PostRepositoryPort $postRepo,
        private CommentRepositoryPort $commentRepo
    ){}

    public function execute(string $id): void
    {
        $authorId = new AuthorIdValueObject($id);
        $limit = 50;
        $author = $this->repo->readAuthor($authorId);
        
        if (!$author) {
            throw new \Exception("Author not found");
        }

        do {
            $deletedCommentsCount = $this->commentRepo->deleteCommentsByAuthorIdBatch($author->getAuthorIdValue(), $limit);
        } while ($deletedCommentsCount >= $limit);

        do {
            $posts = $this->postRepo->findByAuthorIdBatch($authorId->value(), $limit);

            foreach ($posts as $post) {
                $this->commentRepo->deleteCommentsByPostId($post->getPostIdValue());
                $this->postRepo->deletePost($post->getPostId());
            }

            $currentPostsCount = count($posts);
        } while ($currentPostsCount >= $limit);

        $this->repo->deleteAuthor($authorId);
    }
}