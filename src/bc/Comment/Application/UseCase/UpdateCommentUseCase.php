<?php

namespace Src\bc\Comment\Application\UseCase;

use Src\bc\Comment\Application\DTO\CommentUpdateDTO;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentStatusValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentPostIdValueObject;

class UpdateCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repo
    ) {}

    public function execute(CommentUpdateDTO $dto): void
    {
        $id = new CommentIdValueObject($dto->getId());

        $existingComment = $this->repo->readComment($id);
        
        if (!$existingComment) {
            throw new \Exception("No se puede actualizar: El comentario no existe.");
        }

        $description = $dto->getDescription() ?? $existingComment->getDescriptionValue();
        $authorId    = $dto->getAuthorId()    ?? $existingComment->getAuthorIdValue();
        $status      = $dto->getStatus()      ?? $existingComment->getStatusValue();
        $postId      = $dto->getPostId()      ?? $existingComment->getPostIdValue();
        $commentDate = $dto->getCommentDate() ?? $existingComment->getCommentDateValue();
        
        $comment = new Comment(
            $id,
            new CommentDescriptionValueObject($description),
            new CommentAuthorIdValueObject($authorId),
            new CommentStatusValueObject($status),
            new CommentPostIdValueObject($postId),
            new CommentDateValueObject($commentDate)
        );

        $this->repo->updateComment($comment);
    }
}