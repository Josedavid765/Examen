<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutAuthorController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Sesión cerrada correctamente en el servidor'
        ], 200);
    }
}