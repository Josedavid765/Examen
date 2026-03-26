<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Author\Application\UseCase\DeleteAuthorUseCase;

class DeleteAuthorController extends Controller
{
    public function __construct(private DeleteAuthorUseCase $useCase){}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $this->useCase->execute($id);

            return response()->json([
                'status' => 'deleted',
                'message' => "Autor y todas sus dependencias eliminados correctamente."
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
