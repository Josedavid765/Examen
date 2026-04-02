<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\CreateAuthorUseCase;
use Src\BC\Author\Application\DTO\AuthorDTO;

class CreateAuthorController extends Controller
{
    public function __construct(private CreateAuthorUseCase $useCase){}

    public function __invoke(Request $request): JsonResponse
    {
        try{
            $dto = new AuthorDTO(
                    $request->input('id'),
                    $request->input('firstName'),
                    $request->input('lastName'),
                    $request->input('birthDate')
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
