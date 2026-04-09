<?php

namespace Src\BC\Post\Infrastructure\Repositories;

use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Post\Infrastructure\Traits\CreatePostTrait;
use Src\BC\Post\Infrastructure\Traits\ReadPostTrait;
use Src\BC\Post\Infrastructure\Traits\UpdatePostTrait;
use Src\BC\Post\Infrastructure\Traits\DeletePostTrait;
use Src\BC\Post\Infrastructure\Traits\ListPostsTrait;
use Src\BC\Post\Infrastructure\Traits\FindByAuthorIdBatchTrait;
use Src\BC\Post\Infrastructure\Traits\DeletePostsByAuthorIdTrait;
use Src\BC\Post\Infrastructure\Traits\ListPostByAuthorIdTrait;

class EloquentPostRepository implements PostRepositoryPort
{
    use CreatePostTrait,
        ReadPostTrait,
        UpdatePostTrait,
        DeletePostTrait,
        ListPostsTrait,
        ListPostByAuthorIdTrait,
        FindByAuthorIdBatchTrait,
        DeletePostsByAuthorIdTrait;
}
