<?php

namespace Src\BC\Post\Application\UseCase;

use Src\BC\Post\Application\Port\PostRepositoryPort;

class ListPostsUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(): array
    {
        return $this->repo->listPosts();
    }
}
