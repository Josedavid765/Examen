<?php

namespace Src\bc\Comment\UI\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\bc\Comment\Application\UseCase\UpdateCommentUseCase;
use Src\bc\Comment\Application\DTO\CommentUpdateDTO;
use Exception;

class UpdateCommentController
{
    public function __construct(
        private UpdateCommentUseCase $updateCommentUseCase
    ) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new CommentUpdateDTO(
                $id,
                $request->input('description'),
                $request->input('authorId'),
                $request->input('status'),
                $request->input('postId'),
                $request->input('commentDate')
            );

            $this->updateCommentUseCase->execute($dto);

            return response()->json([
                'message' => 'Comment actualizado correctamente'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}