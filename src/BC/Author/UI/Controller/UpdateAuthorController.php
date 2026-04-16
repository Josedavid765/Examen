<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\UpdateAuthorUseCase;
use Src\BC\Author\Application\DTO\AuthorUpdateDTO;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateAuthorController extends Controller
{
    public function __construct(private UpdateAuthorUseCase $useCase){}

    public function __invoke(Request $request, string $id):JsonResponse
    {
        try
        {
            $dto = new AuthorUpdateDTO(
                $id,
                $request->input('firstName'),
                $request->input('lastName'),
                $request->input('birthDate'),
                $request->input('email'),
                $request->input('password')
            );

            $author = $this->useCase->execute($dto);

            return response()->json([
                'status' => 'updated',
                'data' => $author->getAuthorIdValue()
            ]);
        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
