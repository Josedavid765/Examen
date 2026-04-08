<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;

class ListCommentsByAuthorIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $authorId, string $order = 'commentDate', string $direction = 'desc', int $page = 1, int $perPage = 10): array
    {
        $authorIdVO = new CommentAuthorIdValueObject($authorId);
        return $this->repository->listCommentsByAuthorId($authorIdVO, $order, $direction, $page, $perPage);
    }
}
