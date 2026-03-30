<?php

namespace Src\bc\Post\UI\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Src\bc\Post\Application\UseCase\CreatePostUseCase;
use Src\bc\Post\Application\DTO\PostDTO;
use Exception;

class CreatePostController
{
    public function __construct(
        private CreatePostUseCase $createPostUseCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $dto = new PostDTO(
                $request->input('id'),
                $request->input('subject'),
                $request->input('description'),
                $request->input('publish_date'),
                $request->input('status'),
                $request->input('author_id'),
                $request->input('num_comments', 0)
            );

            $this->createPostUseCase->execute($dto);

            return response()->json([
                'message' => 'Post creado correctamente'
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}