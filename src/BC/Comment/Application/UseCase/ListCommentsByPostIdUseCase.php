<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;

class ListCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId): array
    {
        $postIdVO = new CommentPostIdValueObject($postId);
        return $this->repository->listByPostID($postIdVO);
    }
}
