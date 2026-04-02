<?php

return [
    App\Providers\AppServiceProvider::class,
    Src\BC\Author\Infrastructure\Services\DependencyInversionServices::class,
    Src\BC\Post\Infrastructure\Services\DependencyInversionServices::class,
    Src\BC\Comment\Infrastructure\Services\DependencyInversionServices::class,
];
