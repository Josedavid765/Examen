<?php

namespace Src\bc\Post\UI\Controller;

use Illuminate\Http\JsonResponse;
use Src\bc\Post\Application\UseCase\ListPostsUseCase;
use Exception;

class ListPostsController
{
    public function __construct(
        private ListPostsUseCase $listPostsUseCase
    ) {}

    public function __invoke(): JsonResponse
    {
        try {
            $posts = $this->listPostsUseCase->execute();

            $data = array_map(function ($post) {
                return [
                    'id'           => $post->getPostIdValue(),
                    'author_id'    => $post->getAuthorIdValue(),
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publish_date' => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'num_comments' => $post->getNumCommentsValue(),
                ];
            }, $posts);

            return response()->json([
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
