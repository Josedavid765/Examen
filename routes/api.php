<?php

use Illuminate\Support\Facades\Route;
use Src\BC\Author\UI\Controller\CreateAuthorController;
use Src\BC\Author\UI\Controller\ReadAuthorController;
use Src\BC\Author\UI\Controller\UpdateAuthorController;
use Src\BC\Author\UI\Controller\DeleteAuthorController;
use Src\BC\Author\UI\Controller\ListAuthorsController;
use Src\BC\Author\UI\Controller\ListAuthorPostsController;

use Src\BC\Post\UI\Controller\CreatePostController;
use Src\BC\Post\UI\Controller\ReadPostController;
use Src\BC\Post\UI\Controller\UpdatePostController;
use Src\BC\Post\UI\Controller\DeletePostController;
use Src\BC\Post\UI\Controller\ListPostsController;

use Src\BC\Comment\UI\Controller\CreateCommentController;
use Src\BC\Comment\UI\Controller\ReadCommentController;
use Src\BC\Comment\UI\Controller\UpdateCommentController;
use Src\BC\Comment\UI\Controller\DeleteCommentController;
use Src\BC\Comment\UI\Controller\ListCommentsByPostIdController;
use Src\BC\Comment\UI\Controller\ListCommentsByAuthorIdController;

Route::prefix('authors')->group(function () {
    Route::post('/', CreateAuthorController::class);
    Route::get('/{id}', ReadAuthorController::class);
    Route::put('/{id}', UpdateAuthorController::class);
    Route::delete('/{id}', DeleteAuthorController::class);
    Route::get('/{id}/posts', ListAuthorPostsController::class);
    Route::get('/', ListAuthorsController::class);
    Route::get('/{id}/comments', ListCommentsByAuthorIdController::class);
});

Route::prefix('posts')->group(function () {
    Route::post('/', CreatePostController::class);
    Route::get('/{id}', ReadPostController::class);
    Route::put('/{id}', UpdatePostController::class);
    Route::delete('/{id}', DeletePostController::class);
    Route::get('/', ListPostsController::class);
    Route::get('/{id}/comments', ListCommentsByPostIdController::class);
});


Route::prefix('comments')->group(function () {
    Route::post('/', CreateCommentController::class);
    Route::get('/{id}', ReadCommentController::class);
    Route::put('/{id}', UpdateCommentController::class);      
    Route::delete('/{id}', DeleteCommentController::class);
});