<?php

namespace Src\BC\Post\UI\Controller;

use Illuminate\Http\JsonResponse;
use Src\BC\Post\Application\UseCase\DeletePostUseCase;
use Exception;

class DeletePostController
{
    public function __construct(
        private DeletePostUseCase $deletePostUseCase
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->deletePostUseCase->execute($id);

            return response()->json([
                'message' => 'Post eliminado correctamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
