<?php

namespace Src\BC\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Comment\Application\DTO\CommentDTO;
use Src\BC\Comment\Application\UseCase\CreateCommentUseCase;

class CreateCommentController extends Controller
{
    public function __construct(
        private CreateCommentUseCase $createCommentUseCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'description' => 'required|string|min:1',
                'authorId'    => 'required|string',
                'status'      => 'required|string',
                'postId'      => 'required|string',
                'commentDate' => 'required|string',
            ]);

            $commentDto = new CommentDTO(
                null, 
                $request->input('description'),
                $request->input('authorId'),
                $request->input('status'),
                $request->input('postId'),
                $request->input('commentDate')
            );

            $this->createCommentUseCase->execute($commentDto);

            return response()->json(['message' => 'Comment created successfully'], 201);

        } catch (\InvalidArgumentException | \DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
