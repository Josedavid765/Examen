<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\bc\Author\Application\UseCase\UpdateAuthorUseCase;
use Src\bc\Author\Application\DTO\AuthorDTO;

class UpdateAuthorController extends Controller
{
    public function __construct(private UpdateAuthorUseCase $useCase){}

    public function __invoke(Request $request, string $id)
    {
        try
        {
            $dto = new AuthorDTO(
                $id,
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('birth_date')
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
