<?php

namespace Src\BC\Post\Application\UseCase;
use Src\BC\Post\Application\Port\PostRepositoryPort;

class ListPostsByAuthorId
{
    public function __construct(private PostRepositoryPort $postRepo) {}

    public function execute(string $authorId, string $order='publishDate', string $direction='asc', int $page=1, int $perPage=10)
    {
        return $this->postRepo->listPostsByAuthorId($authorId, $order, $direction, $page, $perPage);
    }
}
