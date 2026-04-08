<?php

namespace Src\BC\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Comment\Application\UseCase\ListCommentsByPostIdUseCase;
use Src\BC\Comment\Domain\Entities\Comment;

class ListCommentsByPostIdController extends Controller
{
    public function __construct(
        private ListCommentsByPostIdUseCase $listCommentsByPostIdUseCase
    ) {}

    public function __invoke(Request $request, string $postId): JsonResponse
    {
        try {
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('perPage', 10);

            $orderParam = $request->query('order', '-commentDate');
            $direction = str_starts_with($orderParam, '-') ? 'desc' : 'asc';
            $orderInput = ltrim($orderParam, '+-');

            $orderMap = [
                'id'          => 'id',
                'description' => 'description',
                'commentDate' => 'comment_date',
            ];

            $dbColumn = $orderMap[$orderInput] ?? 'comment_date';

            $result = $this->listCommentsByPostIdUseCase->execute($postId, $dbColumn,$direction, $page, $perPage);

            $data = array_map(function (Comment $comment) {
                return [
                    'id'           => $comment->getCommentIdValue(),
                    'description'  => $comment->getDescriptionValue(),
                    'authorId'     => $comment->getAuthorIdValue(),
                    'status'       => $comment->getStatusValue(),
                    'postId'       => $comment->getPostIdValue(),
                    'commentDate'  => $comment->getCommentDateValue(),
                ];
            }, $result['items']);

            return response()->json([
                'status' => 'success',
                'data'   => $data,
                'meta'   => $result['pagination']
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error'  => $e->getMessage()
            ], 500);
        }
    }
}
