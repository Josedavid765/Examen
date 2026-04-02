<?php

namespace Src\bc\Post\Application\UseCase;

use Src\bc\Post\Application\DTO\PostUpdateDTO;
use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\bc\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\bc\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\bc\Post\Domain\ValueObject\PostStatusValueObject;
use Src\bc\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\bc\Post\Domain\ValueObject\PostCommentCount;

class UpdatePostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(PostUpdateDTO $dto): void
    {
        $postId = new PostIdValueObject($dto->getPostId());

        if (!$this->repo->readPost($postId)) {
            throw new \Exception("Post not found");
        }

        $post = new Post(
            $postId,
            new PostSubjectValueObject($dto->getsubject()),
            new PostDescriptionValueObject($dto->getDescription()),
            new PostPublishDateValueObject($dto->getPublishdate()),
            new PostStatusValueObject($dto->getStatus()),
            new PostAuthorIdValueObject($dto->getAuthorId()),
            new PostCommentCount((int)$dto->getNumComments())
        );

        $this->repo->updatePost($post);
    }
}
