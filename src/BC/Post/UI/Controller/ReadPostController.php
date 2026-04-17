<?php

namespace Src\BC\Post\UI\Controller;

use Illuminate\Http\JsonResponse;
use Src\BC\Post\Application\UseCase\ReadPostUseCase;
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
                    'authorId'    => $post->getAuthorIdValue(),
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publishDate' => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'numComments' => $post->getNumCommentsValue(),
                    'authorName'   => $post->getAuthorFullNameValue(),
                ]
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
