<?php

namespace Src\bc\Comment\Infraestructure\Service;

use Illuminate\Support\ServiceProvider;
use Src\bc\Comment\Application\Port\CommentRepositoryPort;
use Src\bc\Comment\Infraestructure\Repositories\EloquentCommentRepository;

class DependencyInversionServices extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CommentRepositoryPort::class,
            EloquentCommentRepository::class
        );
    }
}