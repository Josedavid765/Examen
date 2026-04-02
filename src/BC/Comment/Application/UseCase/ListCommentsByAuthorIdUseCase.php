<?php

namespace Src\BC\Comment\Application\UseCase;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;

class ListCommentsByAuthorIdUseCase
{
    public function __construct(
        private CommentRepositoryPort $repository
    ) {}

    public function execute(string $authorId): array
    {
        $authorIdVO = new \Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject($authorId);
        return $this->repository->listCommentsByAuthorId($authorIdVO);
    }
}
