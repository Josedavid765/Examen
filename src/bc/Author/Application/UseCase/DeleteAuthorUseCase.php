<?php

namespace Src\bc\Author\Application\UseCase;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Post\Domain\Ports\PostRepositoryPort;
use Src\bc\Comment\Domain\Ports\CommentRepositoryPort;
use Src\bc\Author\Domain\ValueObject\AuthorId;

class DeleteAuthorUseCase
{
    public function __construct(
        private AuthorRepositoryport $repo,
        private PostRepositoryPort $postRepo,
        private CommentRepositoryPort $commentRepo
    ){}

    public function execute(string $id): void
    {
        $authorId = new AuthorId($id);
        $limit = 50;

        do {
            $deletedCount = $this->commentRepo->deleteBatchByAuthorId($authorId->value(), $limit);
        } while ($deletedCount >= $limit);

        do {
            $posts = $this->postRepo->findBatchByAuthorId($authorId->value(), $limit);

            foreach ($posts as $post) {
                $this->commentRepo->deleteByPostId($post->getId());
                $this->postRepo->deletePost($post->getId());
            }
            
            $countPosts = count($posts);
        } while ($countPosts >= $limit);

        $this->repo->deleteAuthor($authorId);
    }
}