<?php

namespace Src\bc\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\bc\Comment\Application\DTO\CommentDTO;
use Src\bc\Comment\Application\UseCase\UpdateCommentUseCase;

class UpdateCommentController extends Controller
{
    public function __construct(
        private UpdateCommentUseCase $updateCommentUseCase
    ) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $request->validate([
                'description' => 'required|string|min:1',
                'status'      => 'required|string',
            ]);

            $commentDto = new CommentDTO(
                $id,
                $request->input('description'),
                $request->input('authorId', ''),
                $request->input('status'),
                $request->input('postId', ''),
                $request->input('commentDate', '')
            );

            $this->updateCommentUseCase->execute($commentDto);

            return response()->json(['message' => 'Comment updated successfully'], 200);

        } catch (\InvalidArgumentException | \DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            // Manejamos el 404 si el comentario no existe
            $statusCode = $e->getMessage() === "Comment not found" ? 404 : 500;
            return response()->json(['error' => $e->getMessage()], $statusCode);
        }
    }
}
