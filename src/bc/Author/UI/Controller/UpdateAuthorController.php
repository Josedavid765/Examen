<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\bc\Author\Application\UseCase\UpdateAuthorUseCase;
use Src\bc\Author\Application\DTO\AuthorUpdateDTO;

class UpdateAuthorController extends Controller
{
    public function __construct(private UpdateAuthorUseCase $useCase){}

    public function __invoke(Request $request, string $id)
    {
        try
        {
            $dto = new AuthorUpdateDTO(
                $id,
                $request->input('firstname'),
                $request->input('lastname'),
                $request->input('birthdate')
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
