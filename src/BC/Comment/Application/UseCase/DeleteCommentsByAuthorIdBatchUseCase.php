<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentsByAuthorIdBatchUseCase
{
    private CommentRepositoryPort $repository;

    public function __construct(CommentRepositoryPort $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $authorId, int $limit): int
    {
        $authorIdVO = new \Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject($authorId);
        return $this->repository->deleteCommentsByAuthorIdBatch($authorIdVO, $limit);
    }
}