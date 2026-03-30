<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\DTO\CommentDTO;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentStatusValueObject;

class UpdateCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(CommentDTO $dto): void
    {
        $exists = $this->repository->readComment($dto->getId());

        if (!$exists) {
            throw new \Exception("Comment not found");
        }

        $comment = new Comment(
            new CommentIdValueObject($dto->getId()),
            new CommentDescriptionValueObject($dto->getDescription()),
            new CommentAuthorIdValueObject($dto->getAuthorId()),
            new CommentStatusValueObject($dto->getStatus()),
            new CommentPostIdValueObject($dto->getPostId()),
            new CommentDateValueObject($dto->getCommentDate())
        );

        $this->repository->updateComment($comment);
    }
}