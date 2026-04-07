<?php

namespace Src\BC\Comment\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\BC\Comment\Application\UseCase\ReadCommentUseCase;

class ReadCommentController extends Controller
{
    public function __construct(
        private ReadCommentUseCase $readCommentUseCase
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $comment = $this->readCommentUseCase->execute($id);

            return response()->json([
                'id'           => $comment->getCommentIdValue(),
                'description'  => $comment->getDescriptionValue(),
                'authorId'    => $comment->getAuthorIdValue(),
                'status'       => $comment->getStatusValue(),
                'postId'      => $comment->getPostIdValue(),
                'commentDate' => $comment->getCommentDateValue(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
