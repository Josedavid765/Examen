<?php

namespace Src\bc\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\bc\Author\Application\UseCase\ListAuthorPostsUseCase;

class ListAuthorPostsController extends Controller
{
    public function __construct(private ListAuthorPostsUseCase $useCase) {}

    public function __invoke(string $id): JsonResponse
    {
        try {
            $posts = $this->useCase->execute($id);
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
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
