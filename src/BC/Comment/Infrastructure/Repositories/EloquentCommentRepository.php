<?php

namespace Src\BC\Comment\Infrastructure\Repositories;

use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Infrastructure\Traits\CreateCommentTrait;
use Src\BC\Comment\Infrastructure\Traits\ReadCommentTrait;
use Src\BC\Comment\Infrastructure\Traits\UpdateCommentTrait;
use Src\BC\Comment\Infrastructure\Traits\DeleteCommentTrait;
use Src\BC\Comment\Infrastructure\Traits\ListCommentsByPostIdTrait;
use Src\BC\Comment\Infrastructure\Traits\ListCommentsByAuthorIdTrait;
use Src\BC\Comment\Infrastructure\Traits\DeleteCommentsByPostIdTrait;
use Src\BC\Comment\Infrastructure\Traits\DeleteCommentsByAuthorIdBatchTrait;

class EloquentCommentRepository implements CommentRepositoryPort
{
    use CreateCommentTrait,
        ReadCommentTrait,
        UpdateCommentTrait,
        DeleteCommentTrait,
        ListCommentsByPostIdTrait,
        ListCommentsByAuthorIdTrait,
        DeleteCommentsByPostIdTrait,
        DeleteCommentsByAuthorIdBatchTrait;
}
