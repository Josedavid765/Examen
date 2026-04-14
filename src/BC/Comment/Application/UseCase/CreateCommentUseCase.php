<?php

namespace Src\BC\Comment\Application\UseCase;

use Ramsey\Uuid\Uuid;
use Src\BC\Author\Application\UseCase\CheckAuthorExistsUseCase;
use Src\BC\Comment\Application\DTO\CommentDTO;
use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Domain\Entities\Comment;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentStatusValueObject;
use Src\BC\Post\Application\UseCase\ReadPostUseCase;
class CreateCommentUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository,
        private CheckAuthorExistsUseCase $checkAuthorUseCase,
        private ReadPostUseCase $readPostUseCase
    ) {}

    public function execute(CommentDTO $dto): Comment
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
            new CommentDateValueObject($dto->getCommentDate()),
            null
        );

        $this->repository->createComment($comment);
        return $comment;
    }
}