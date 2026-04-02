<?php

namespace Src\BC\Author\Infrastructure\Repositories;

use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Infrastructure\Traits\CreateAuthorTrait;
use Src\BC\Author\Infrastructure\Traits\DeleteAuthorTrait;
use Src\BC\Author\Infrastructure\Traits\ReadAuthorTrait;
use Src\BC\Author\Infrastructure\Traits\UpdateAuthorTrait;
use Src\BC\Author\Infrastructure\Traits\ListAuthorTrait;

class EloquentAuthorRepository implements AuthorRepositoryPort
{
    use CreateAuthorTrait;
    use ReadAuthorTrait;
    use UpdateAuthorTrait;
    use DeleteAuthorTrait;
    use ListAuthorTrait;
}