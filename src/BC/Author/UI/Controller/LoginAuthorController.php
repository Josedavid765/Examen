<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\LoginAuthorUseCase;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;

class LoginAuthorController extends Controller
{
    public function __construct(private LoginAuthorUseCase $useCase) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $email    = new AuthorEmailValueObject($request->input('email', ''));
            $password = new AuthorPasswordValueObject($request->input('password', ''));

            $author = $this->useCase->execute($email, $password);

            if (!$author) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id'       => $author->getAuthorIdValue(),
                    'fullName' => $author->getAuthorFirstNameValue() . ' ' . $author->getAuthorLastNameValue()
                ]
            ], 200);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage(), // <--- CAMBIA ESTO
                'file' => $e->getFile(),       // <--- AÑADE ESTO
                'line' => $e->getLine()
            ], 500);
        }
    }
}