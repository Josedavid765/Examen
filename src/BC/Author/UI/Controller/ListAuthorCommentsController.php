<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\ListAuthorCommentsUseCase;

class ListAuthorCommentsController extends Controller
{
    public function __construct(
        private ListAuthorCommentsUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {

            $order = $request->query('order', 'comment_date');

            $rawDirection = $request->query('direction', '-');

            $direction = ($rawDirection === '-' || $rawDirection === 'desc') ? 'desc' : 'asc';

            $comments = $this->useCase->execute($id, $order, $direction);

            $data = array_map(fn($comment) => [
                'id'          => $comment->getCommentIdValue(),
                'postId'      => $comment->getPostIdValue(),
                'content'     => $comment->getDescriptionValue(),
                'commentDate' => $comment->getCommentDateValue()
            ], $comments);

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
