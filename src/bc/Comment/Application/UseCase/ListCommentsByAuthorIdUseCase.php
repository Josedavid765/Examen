<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class ListCommentsByAuthorIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $authorId): array
    {
        return $this->repository->listCommentsByAuthorId($authorId);
    }
}
