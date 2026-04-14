<?php

namespace Src\BC\Post\Application\UseCase;

use Src\BC\Post\Application\DTO\PostDTO;
use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Author\Application\UseCase\CheckAuthorExistsUseCase;
use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\BC\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\BC\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\BC\Post\Domain\ValueObject\PostStatusValueObject;
use Src\BC\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostCommentCount;
use Exception;

class CreatePostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo,
        private CheckAuthorExistsUseCase $checkAuthorExists
    ) {}

    public function execute(PostDTO $dto): Post
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
            new PostCommentCount((int)$dto->getNumComments()),
            null
        );

        $this->repo->createPost($post);
        return $post;
    }
}