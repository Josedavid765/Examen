<?php

namespace Src\BC\Post\Application\UseCase;

use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Exception;

class ReadPostUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(string $id): ?Post
    {
        $postId = new PostIdValueObject($id);
        $post = $this->repo->readPost($postId);

        if (!$post) {
            throw new Exception("Post not found");
        }

        return $post;
    }
}
