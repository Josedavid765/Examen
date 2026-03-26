<?php

namespace Src\bc\Author\Infraestructure\service;

use Illuminate\Support\ServiceProvider;
use Src\bc\Author\Application\Port\AuthorRepositoryport;
use Src\bc\Author\Infraestructure\Repositories\EloquentAuthorRepository;
use Src\bc\Author\Infraestructure\Traits\CreateAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\DeleteAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\ListAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\ReadAuthorTrait;
use Src\bc\Author\Infraestructure\Traits\UpdateAuthorTrait;

class DependencyInversionServices extends ServiceProvider
{
    public function register():void
    {
        $this->app->when(
            [
                CreateAuthorTrait::class,
                ReadAuthorTrait::class,
                UpdateAuthorTrait::class,
                DeleteAuthorTrait::class,
                ListAuthorTrait::class
            ]
        )->needs(AuthorRepositoryport::class)->give(EloquentAuthorRepository::class);
    }
}
