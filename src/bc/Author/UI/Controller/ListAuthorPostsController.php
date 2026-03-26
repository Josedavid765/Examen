<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Author\Application\UseCases\ListAuthorPostsUseCase;

class ListAuthorPostsController extends Controller
{
    public function __construct(private ListAuthorPostsUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $posts = $this->useCase->execute($id);
            return response()->json(['status' => 'success', 'data' => $posts]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
