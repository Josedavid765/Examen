<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\BC\Author\Application\UseCase\ListAuthorCommentsUseCase;

class ListAuthorCommentsController extends Controller
{
    public function __construct(
        private ListAuthorCommentsUseCase $useCase
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $comments = $this->useCase->execute($id);

            $data = array_map(fn($comment) => [
                'id'      => $comment->getCommentIdValue(),
                'postId' => $comment->getPostIdValue(),
                'content' => $comment->getDescriptionValue()
            ], $comments);

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
