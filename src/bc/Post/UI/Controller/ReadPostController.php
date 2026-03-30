<?php

namespace Src\bc\Post\UI\Controller;

use Illuminate\Http\JsonResponse;
use Src\bc\Post\Application\UseCase\ReadPostUseCase;
use Exception;

class ReadPostController
{
    public function __construct(
        private ReadPostUseCase $readPostUseCase
    ) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $post = $this->readPostUseCase->execute($id);

            if (!$post) {
                return response()->json([
                    'error' => 'Post no encontrado'
                ], 404);
            }

            return response()->json([
                'data' => [
                    'id'           => $post->getPostIdValue(),
                    'author_id'    => $post->getAuthorIdValue(),
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publish_date' => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'num_comments' => $post->getNumCommentsValue(),
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
