<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Domain\Entities\Comment;

class ReadCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $id): Comment
    {
        $comment = $this->repository->readComment($id);

        if (!$comment) {
            throw new \Exception("Comment not found");
        }

        return $comment;
    }
}
