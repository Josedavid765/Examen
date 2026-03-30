<?php

namespace Src\bc\Post\Infraestructure\Service;

use Illuminate\Support\ServiceProvider;
use Src\bc\Post\Application\Port\PostRepositoryPort;
use Src\bc\Post\Infraestructure\Repositories\EloquentPostRepository;

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
