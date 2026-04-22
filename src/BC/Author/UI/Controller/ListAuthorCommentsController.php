<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\ListAuthorCommentsUseCase;
use Src\BC\Comment\Domain\Entities\Comment;

class ListAuthorCommentsController extends Controller
{
    public function __construct(
        private ListAuthorCommentsUseCase $useCase
    ) {}

    public function __invoke(Request $request, string $id): JsonResponse
    {
        try {
            $limit = (int) $request->query('limit', 10);
            $offset = (int) $request->query('offset', 0);

            $order = $request->query('order', 'comment_date');
            $rawDirection = $request->query('direction', '-');
            $direction = ($rawDirection === '-' || $rawDirection === 'desc') ? 'desc' : 'asc';

            $comments = $this->useCase->execute($id, $limit, $offset, $order, $direction);

            $data = array_map(fn($comment) => [
                'id'             => $comment->getCommentIdValue(),
                'description'    => $comment->getDescriptionValue(),
                'authorId'       => $comment->getAuthorIdValue(),
                'authorFullName' => $comment->getAuthorFullNameValue() ?? 'Autor Desconocido',
                'status'         => strtoupper($comment->getStatusValue()),
                'postId'         => $comment->getPostIdValue(),
                'commentDate'    => $comment->getCommentDateValue()
            ], $comments);

            return response()->json([
                'status' => 'success',
                'data'   => $data,
                'meta'   => $comments
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
