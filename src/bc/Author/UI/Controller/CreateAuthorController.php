<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\bc\Author\Application\UseCase\CreateAuthorUseCase;
use Src\bc\Author\Application\DTO\AuthorDTO;

class CreateAuthorController extends Controller
{
    public function __construct(private CreateAuthorUseCase $useCase){}

    public function __invoke(Request $request): JsonResponse
    {
        try{
            $dto = new AuthorDTO(
                    $request->input('id'),
                    $request->input('firstname'),
                    $request->input('lastname'),
                    $request->input('birthdate')
                );

            $author = $this->useCase->execute($dto);

            return response()->json([
                    'status' => 'success',
                    'data' => $author->getFullName()
                ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
