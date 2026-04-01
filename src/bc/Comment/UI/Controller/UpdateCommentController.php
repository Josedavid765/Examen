<?php

namespace Src\bc\Post\Application\UseCase;

// IMPORTANTE: Ahora importamos el UpdateDTO, no el normal
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

    public function __invoke(PostUpdateDTO $dto): void
    {
        $postId = new PostIdValueObject($dto->getPostId());

        $existingPost = $this->repo->readPost($postId);

        if (!$existingPost) {
            throw new \Exception("Post not found");
        }

        $subject     = $dto->getsubject()     ?? $existingPost->getSubjectValue();
        $description = $dto->getDescription() ?? $existingPost->getDescriptionValue();
        $publishDate = $dto->getPublishdate() ?? $existingPost->getPublishDateValue();
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
    }
}