<?php

namespace Src\bc\Post\Application\UseCase;

use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
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
