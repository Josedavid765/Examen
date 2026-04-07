<?php

namespace Src\BC\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\BC\Comment\Application\UseCase\ListCommentsByPostIdUseCase;
use Src\BC\Comment\Domain\Entities\Comment;

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
                    'authorId'    => $comment->getAuthorIdValue(),
                    'status'       => $comment->getStatusValue(),
                    'postId'      => $comment->getPostIdValue(),
                    'commentDate' => $comment->getCommentDateValue(),
                ];
            }, $comments);

            return response()->json($response, 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
