<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\Entities\Comment;
use Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;

class ReadCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $id): Comment
    {
        $commentId = new CommentIdValueObject($id);
        $comment = $this->repository->readComment($commentId);

        if (!$comment) {
            throw new \Exception("Comment not found");
        }

        return $comment;
    }
}
