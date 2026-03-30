<?php

namespace Src\bc\Post\Infraestructure\Repositories;

use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Post\Infraestructure\Traits\CreatePostTrait;
use Src\bc\Post\Infraestructure\Traits\ReadPostTrait;
use Src\bc\Post\Infraestructure\Traits\UpdatePostTrait;
use Src\bc\Post\Infraestructure\Traits\DeletePostTrait;
use Src\bc\Post\Infraestructure\Traits\ListPostsTrait;
use Src\bc\Post\Infraestructure\Traits\FindByAuthorIdBatchTrait;
use Src\bc\Post\Infraestructure\Traits\DeletePostsByAuthorIdTrait;

class EloquentPostRepository implements PostRepositoryPort
{
    use CreatePostTrait,
        ReadPostTrait,
        UpdatePostTrait,
        DeletePostTrait,
        ListPostsTrait,
        FindByAuthorIdBatchTrait,
        DeletePostsByAuthorIdTrait;
}
