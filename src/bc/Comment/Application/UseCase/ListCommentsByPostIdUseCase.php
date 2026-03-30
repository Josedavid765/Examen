<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class ListCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): array
    {
        return $this->repository->listByPostId($postId);
    }
}
