<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class DeleteCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $id): void
    {
        $commentId = new \Src\BC\Comment\Domain\ValueObject\CommentIdValueObject($id);
        $comment = $this->repository->readComment($commentId);

        if (!$comment) {
            throw new \Exception("Comment not found");
        }

        $this->repository->deleteComment($commentId);
    }
}
