<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Author\Application\UseCase\ListAuthorsUseCase;

class ListAuthorsController extends Controller
{
    public function __construct(private ListAuthorsUseCase $useCase){}

    public function __invoke(): JsonResponse
    {
        $authors = $this->useCase->execute();

        $data = array_map(fn($author) => [
            'id' => $author->getAuthorIdValue(),
            'fullname' => $author->getAuthorFirstNameValue() . ' ' . $author->getAuthorLastNameValue(),
            'firstname' => $author->getAuthorFirstNameValue(),
            'lastname' => $author->getAuthorLastNameValue(),
            'birthdate' => $author->getAuthorBirthDateValue()
        ], $authors);

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
