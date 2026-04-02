<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class ListCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): array
    {
        $postIdVO = new \Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject($postId);
        return $this->repository->listByPostID($postIdVO);
    }
}
