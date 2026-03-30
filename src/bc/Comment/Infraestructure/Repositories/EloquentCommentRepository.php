<?php

namespace Src\bc\Comment\Infraestructure\Repositories;

use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Infraestructure\Traits\CreateCommentTrait;
use Src\bc\Comment\Infraestructure\Traits\ReadCommentTrait;
use Src\bc\Comment\Infraestructure\Traits\UpdateCommentTrait;
use Src\bc\Comment\Infraestructure\Traits\DeleteCommentTrait;
use Src\bc\Comment\Infraestructure\Traits\ListCommentsByPostIdTrait;
use Src\bc\Comment\Infraestructure\Traits\ListCommentsByAuthorIdTrait;
use Src\bc\Comment\Infraestructure\Traits\DeleteCommentsByPostIdTrait;
use Src\bc\Comment\Infraestructure\Traits\DeleteCommentsByAuthorIdBatchTrait;

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
