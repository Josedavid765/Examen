<?php

namespace Src\BC\Post\Application\Port;

use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Domain\ValueObject\PostIdValueObject;

interface PostRepositoryPort
{
    public function createPost(Post $post): void;

    public function readPost(PostIdValueObject $id): ?Post;

    public function updatePost(Post $post): void;

    public function deletePost(PostIdValueObject $id): void;

    public function listPosts(string $order='publishDate', string $direction='asc', int $page=1, int $perPage=10): array;

    public function findByAuthorIdBatch(string $authorId, int $limit): array;
    
    public function deletePostsByAuthorId(string $authorId): void;
}