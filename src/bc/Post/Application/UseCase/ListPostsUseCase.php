<?php

namespace Src\bc\Post\Application\UseCase;

use Src\bc\Post\Application\Port\PostRepositoryPort;

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
