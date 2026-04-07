<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;

class DeleteCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $id): void
    {
        $commentId = new CommentIdValueObject($id);
        $comment = $this->repository->readComment($commentId);

        if (!$comment) {
            throw new \Exception("Comment not found");
        }

        $this->repository->deleteComment($commentId);
    }
}
