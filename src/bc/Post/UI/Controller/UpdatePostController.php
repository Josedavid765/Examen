<?php

namespace Src\bc\Post\UI\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\bc\Post\Application\UseCase\UpdatePostUseCase;
use Src\bc\Post\Application\DTO\PostUpdateDTO;
use Exception;

class UpdatePostController
{
    public function __construct(
        private UpdatePostUseCase $updatePostUseCase
    ) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $dto = new PostUpdateDTO(
                $id,
                $request->input('subject'),
                $request->input('description'),
                $request->input('publish_date'),
                $request->input('status'),
                $request->input('author_id'),
                $request->input('num_comments') 
            );
            $this->updatePostUseCase->execute($dto);

            return response()->json([
                'message' => 'Post actualizado correctamente'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}