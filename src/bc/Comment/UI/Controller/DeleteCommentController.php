<?php

namespace Src\bc\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Comment\Application\UseCase\DeleteCommentUseCase;

class DeleteCommentController extends Controller
{
    public function __construct(
        private DeleteCommentUseCase $deleteCommentUseCase
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->deleteCommentUseCase->execute($id);

            return response()->json(['message' => 'Comment deleted successfully'], 200);

        } catch (\Exception $e) {
            $statusCode = $e->getMessage() === "Comment not found" ? 404 : 500;
            return response()->json(['error' => $e->getMessage()], $statusCode);
        }
    }
}
