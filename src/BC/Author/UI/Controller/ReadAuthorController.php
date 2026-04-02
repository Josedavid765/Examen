<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Src\BC\Author\Application\UseCase\ReadAuthorUseCase;

class ReadAuthorController extends Controller
{
    public function __construct(private ReadAuthorUseCase $useCase){}

    public function __invoke(string $id): JsonResponse
    {
        try
        {
            $author = $this->useCase->execute($id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $author->getAuthorIdValue(),
                    'firstName' => $author->getAuthorFirstNameValue(),
                    'lastName' => $author->getAuthorLastNameValue(),
                    'birthDate' => $author->getAuthorBirthDateValue()
                ]
            ]);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
