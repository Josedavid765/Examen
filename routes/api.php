<?php

use Illuminate\Support\Facades\Route;
use Src\bc\Author\UI\Controller\CreateAuthorController;
use Src\bc\Author\UI\Controller\ReadAuthorController;
use Src\bc\Author\UI\Controller\UpdateAuthorController;
use Src\bc\Author\UI\Controller\DeleteAuthorController;
use Src\bc\Author\UI\Controller\ListAuthorsController;
use Src\bc\Author\UI\Controller\ListAuthorPostsController;

use Src\bc\Post\UI\Controller\CreatePostController;
use Src\bc\Post\UI\Controller\ReadPostController;
use Src\bc\Post\UI\Controller\UpdatePostController;
use Src\bc\Post\UI\Controller\DeletePostController;
use Src\bc\Post\UI\Controller\ListPostsController;

use Src\bc\Comment\UI\Controller\CreateCommentController;
use Src\bc\Comment\UI\Controller\ReadCommentController;
use Src\bc\Comment\UI\Controller\UpdateCommentController;
use Src\bc\Comment\UI\Controller\DeleteCommentController;
use Src\bc\Comment\UI\Controller\ListCommentsByPostIdController;
use Src\bc\Comment\UI\Controller\ListCommentsByAuthorIdController;

Route::prefix('authors')->group(function () {
    Route::post('/', CreateAuthorController::class);
    Route::get('/', ListAuthorsController::class);
    Route::get('/{id}', ReadAuthorController::class);
    Route::put('/{id}', UpdateAuthorController::class);
    Route::delete('/{id}', DeleteAuthorController::class);
    Route::get('/{id}/posts', ListAuthorPostsController::class);
});

Route::prefix('posts')->group(function () {
    Route::get('/', ListPostsController::class);
    Route::post('/', CreatePostController::class);
    Route::get('/{id}', ReadPostController::class);
    Route::put('/{id}', UpdatePostController::class);
    Route::delete('/{id}', DeletePostController::class);
});

Route::post('/comments', CreateCommentController::class);
Route::get('/comments/{id}', ReadCommentController::class);
Route::put('/comments/{id}', UpdateCommentController::class);
Route::delete('/comments/{id}', DeleteCommentController::class);

Route::get('/posts/{postId}/comments', ListCommentsByPostIdController::class);
Route::get('/authors/{authorId}/comments', ListCommentsByAuthorIdController::class);