<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Author\Application\UseCase\ListAuthorCommentsUseCase;

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
                'id'      => $comment->getId(),
                'post_id' => $comment->getPostId(),
                'content' => $comment->getContent()
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
