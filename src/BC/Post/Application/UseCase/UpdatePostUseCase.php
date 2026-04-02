<?php

namespace Src\BC\Post\Application\UseCase;

use Src\BC\Post\Application\DTO\PostUpdateDTO;
use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\BC\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\BC\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\BC\Post\Domain\ValueObject\PostStatusValueObject;
use Src\BC\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostCommentCount;

class UpdatePostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(PostUpdateDTO $dto): Post
    {
        $postId = new PostIdValueObject($dto->getPostId());

        $existingPost = $this->repo->readPost($postId);

        if (!$existingPost) {
            throw new \Exception("Post not found");
        }

        $subject     = $dto->getSubject()     ?? $existingPost->getSubjectValue();
        $description = $dto->getDescription() ?? $existingPost->getDescriptionValue();
        $publishDate = $dto->getPublishDate() ?? $existingPost->getPublishDateValue();
        $status      = $dto->getStatus()      ?? $existingPost->getStatusValue();
        $authorId    = $dto->getAuthorId()    ?? $existingPost->getAuthorIdValue();
        $numComments = $dto->getNumComments() ?? $existingPost->getNumCommentsValue();

        $post = new Post(
            $postId,
            new PostSubjectValueObject($subject),
            new PostDescriptionValueObject($description),
            new PostPublishDateValueObject($publishDate),
            new PostStatusValueObject($status),
            new PostAuthorIdValueObject($authorId),
            new PostCommentCount((int)$numComments)
        );

        $this->repo->updatePost($post);
        return $post;
    }
}
