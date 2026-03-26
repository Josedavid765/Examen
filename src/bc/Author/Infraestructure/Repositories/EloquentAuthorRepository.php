<?php

namespace Src\bc\Author\Infraestructure\Repositories;

use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Infraestructure\Traits\CreateAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\DeleteAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\ReadAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\UpdateAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\ListAuthorTrait;

class EloquentAuthorRepository implements AuthorRepositoryport
{
    use CreateAuthorTrait;
    use ReadAuthorTrait;
    use UpdateAuthorTrait;
    use DeleteAuthorTrait;
    use ListAuthorTrait;
}