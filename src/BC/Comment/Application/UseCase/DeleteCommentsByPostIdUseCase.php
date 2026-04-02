<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): void
    {
        $postIdVO = new \Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject($postId);
        $this->repository->deleteCommentsByPostId($postIdVO);
    }
}
