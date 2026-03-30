<?php

namespace Src\bc\Post\Application\UseCase;

use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Exception;

class DeletePostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(string $id): void
    {
        $postId = new PostIdValueObject($id);

        if (!$this->repo->readPost($postId)) {
            throw new Exception("Post not found");
        }

        $this->repo->deletePost($postId);
    }
}