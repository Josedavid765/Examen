<?php

namespace Src\bc\Comment\Application\UseCase;

use Ramsey\Uuid\Uuid;
use Src\bc\Author\Application\UseCase\CheckAuthorExistsUseCase;
use Src\bc\Comment\Application\DTO\CommentDTO;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Domain\Entities\Comment;
use Src\bc\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Src\bc\Comment\Domain\ValueObject\CommentStatusValueObject;
use Src\bc\Post\Application\UseCase\ReadPostUseCase;

class CreateCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository,
        private CheckAuthorExistsUseCase $checkAuthorUseCase,
        private ReadPostUseCase $readPostUseCase
    ) {}

    public function execute(CommentDTO $dto): void
    {
        if (!$this->checkAuthorUseCase->execute($dto->getAuthorId())) 
        {
            throw new \DomainException("El autor no existe.");
        }

        $this->readPostUseCase->execute($dto->getPostId());

        $id = $dto->getId() ?? Uuid::uuid4()->toString();
        $comment = new Comment(
            new CommentIdValueObject($id),
            new CommentDescriptionValueObject($dto->getDescription()),
            new CommentAuthorIdValueObject($dto->getAuthorId()),
            new CommentStatusValueObject($dto->getStatus()),
            new CommentPostIdValueObject($dto->getPostId()),
            new CommentDateValueObject($dto->getCommentDate())
        );

        $this->repository->createComment($comment);
    }
}