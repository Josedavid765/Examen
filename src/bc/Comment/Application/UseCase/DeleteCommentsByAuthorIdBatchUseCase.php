<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentsByAuthorIdBatchUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $authorId, int $limit): void
    {
        $this->repository->deleteCommentsByAuthorIdBatch($authorId, $limit);
    }
}