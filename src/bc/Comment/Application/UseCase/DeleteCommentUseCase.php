<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $id): void
    {
        $comment = $this->repository->readComment($id);

        if (!$comment) {
            throw new \Exception("Comment not found");
        }

        $this->repository->deleteComment($id);
    }
}
