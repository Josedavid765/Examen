<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): void
    {
        $this->repository->deleteCommentsByPostId($postId);
    }
}
