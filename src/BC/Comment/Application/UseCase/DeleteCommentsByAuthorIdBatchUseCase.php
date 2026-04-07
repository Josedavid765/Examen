<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;

class DeleteCommentsByAuthorIdBatchUseCase
{
    private CommentRepositoryPort $repository;

    public function __construct(CommentRepositoryPort $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $authorId, int $limit): int
    {
        $authorIdVO = new CommentAuthorIdValueObject($authorId);
        return $this->repository->deleteCommentsByAuthorIdBatch($authorIdVO, $limit);
    }
}