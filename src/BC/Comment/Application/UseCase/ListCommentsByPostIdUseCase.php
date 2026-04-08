<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;

class ListCommentsByPostIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $postId, string $order = 'commentDate', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        $postIdVO = new CommentPostIdValueObject($postId);
        return $this->repository->listByPostID($postIdVO, $order, $direction, $page, $perPage);
    }
}
