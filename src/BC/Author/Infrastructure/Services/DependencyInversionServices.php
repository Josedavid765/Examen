<?php

namespace Src\BC\Author\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\BC\Author\Application\Port\AuthorRepositoryPort;
use Src\BC\Author\Infrastructure\Repositories\EloquentAuthorRepository;

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

