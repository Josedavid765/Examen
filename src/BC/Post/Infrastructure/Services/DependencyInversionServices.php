<?php

namespace Src\BC\Post\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\BC\Post\Application\Port\PostRepositoryPort;
use Src\BC\Post\Infrastructure\Repositories\EloquentPostRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register():void
    {
        $this->app->bind(
            PostRepositoryPort::class,
            EloquentPostRepository::class
        );
    }
}
