<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentsByAuthorIdBatchUseCase
{
    private CommentRepositoryPort $repository;

    public function __construct(CommentRepositoryPort $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $authorId, int $limit): int
    {
        return $this->repository->deleteCommentsByAuthorIdBatch($authorId, $limit);
    }
}