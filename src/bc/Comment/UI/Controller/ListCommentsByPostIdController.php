<?php

namespace Src\bc\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Comment\Application\UseCase\ListCommentsByPostIdUseCase;
use Src\bc\Comment\Domain\Entities\Comment;

class ListCommentsByPostIdController extends Controller
{
    public function __construct(
        private ListCommentsByPostIdUseCase $listCommentsByPostIdUseCase
    ) {}

    public function __invoke(string $postId): JsonResponse
    {
        try {
            $comments = $this->listCommentsByPostIdUseCase->execute($postId);

            $response = array_map(function (Comment $comment) {
                return [
                    'id'           => $comment->getCommentIdValue(),
                    'description'  => $comment->getDescriptionValue(),
                    'author_id'    => $comment->getAuthorIdValue(),
                    'status'       => $comment->getStatusValue(),
                    'post_id'      => $comment->getPostIdValue(),
                    'comment_date' => $comment->getCommentDateValue(),
                ];
            }, $comments);

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
