<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\BC\Author\Application\UseCase\ListAuthorsUseCase;
use Illuminate\Http\Request;

class ListAuthorsController extends Controller
{
    public function __construct(private ListAuthorsUseCase $useCase){}

    public function __invoke(Request $request): JsonResponse
    {
        
        $fullName = $request->query('fullname');
        $fullName = $fullName ? mb_strtolower($fullName, 'UTF-8') : null; 

        $page     = (int) $request->query('page', 1);
        $perPage  = (int) $request->query('perPage', 10);

        $direction = $request->query('direction', 'asc');

        $result = $this->useCase->execute($fullName, $page, $perPage, $direction);

        $authors = array_map(fn($author) => [
            'id'        => $author->getAuthorIdValue(),
            'fullName'  => $author->getFullName(),
            'firstName' => $author->getAuthorFirstNameValue(),
            'lastName'  => $author->getAuthorLastNameValue(),
            'birthDate' => $author->getAuthorBirthDateValue()
        ], $result['items']);

        return response()->json([
            'status' => 'success',
            'data'   => $authors,
            'meta'   => $result['pagination']
        ]);
    }
}
