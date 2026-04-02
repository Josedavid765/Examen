<?php

namespace Src\bc\Author\Infraestructure\service;

use Illuminate\Support\ServiceProvider;
use Src\bc\Author\Application\Port\AuthorRepositoryPort;
use Src\bc\Author\Infraestructure\Repositories\EloquentAuthorRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register():void
    {
        $this->app->bind(
            AuthorRepositoryPort::class,
            EloquentAuthorRepository::class
        );
    }
}

