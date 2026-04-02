<?php

namespace Src\bc\Post\Application\UseCase;

use Src\bc\Post\Application\DTO\PostDTO;
use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Author\Application\UseCase\CheckAuthorExistsUseCase;
use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\bc\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\bc\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\bc\Post\Domain\ValueObject\PostStatusValueObject;
use Src\bc\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostCommentCount;
use Exception;

class CreatePostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo,
        private CheckAuthorExistsUseCase $checkAuthorExists
    ) {}

    public function execute(PostDTO $dto): void
    {
        if (!$this->checkAuthorExists->execute($dto->getAuthorId())) {
            throw new Exception("Author not found. Cannot create post.");
        }

        $post = new Post(
            new PostIdValueObject($dto->getPostId()),
            new PostSubjectValueObject($dto->getSubject()),
            new PostDescriptionValueObject($dto->getDescription()),
            new PostPublishDateValueObject($dto->getPublishDate()),
            new PostStatusValueObject($dto->getStatus()),
            new PostAuthorIdValueObject($dto->getAuthorId()),
            new PostCommentCount((int)$dto->getNumComments())
        );

        $this->repo->createPost($post);
    }
}