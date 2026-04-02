<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;

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
            $deletedCommentsCount = $this->commentRepo->deleteCommentsByAuthorIdBatch($authorId->value(), $limit);
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