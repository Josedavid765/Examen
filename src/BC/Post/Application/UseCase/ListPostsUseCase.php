<?php

namespace Src\BC\Post\Application\UseCase;

use Src\BC\Post\Application\Port\PostRepositoryPort;

class ListPostsUseCase
{
    public function __construct(
        private PostRepositoryPort $repo
    ) {}

    public function execute(string $order='publishDate', string $direction='asc', int $page=1, int $perPage=10): array
    {
        return $this->repo->listPosts($order, $direction, $page, $perPage);
    }
}
