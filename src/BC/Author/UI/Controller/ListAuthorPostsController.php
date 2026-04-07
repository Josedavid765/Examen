<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\BC\Author\Application\UseCase\ListAuthorPostsUseCase;

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
                    'authorId'    => $post->getAuthorIdValue(),
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publishDate' => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'numComments' => $post->getNumCommentsValue(),
                ];
            }, $posts);
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
