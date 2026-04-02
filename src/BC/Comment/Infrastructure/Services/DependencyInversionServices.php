<?php

namespace Src\BC\Comment\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Src\BC\Comment\Application\Port\CommentRepositoryPort;
use Src\BC\Comment\Infrastructure\Repositories\EloquentCommentRepository;

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