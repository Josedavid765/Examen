<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;

class ListCommentsByAuthorIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $authorId, string $order = 'comment_date', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        $authorIdVO = new CommentAuthorIdValueObject($authorId);
        $limit = $perPage;
        $offset = ($page - 1) * $perPage;
        return $this->repository->listCommentsByAuthorId($authorId, $limit, $offset, $order, $direction);
    }
}
