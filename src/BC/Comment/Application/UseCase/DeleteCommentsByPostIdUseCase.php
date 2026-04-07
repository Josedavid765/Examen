<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;

class DeleteCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): void
    {
        $postIdVO = new CommentPostIdValueObject($postId);
        $this->repository->deleteCommentsByPostId($postIdVO);
    }
}
