<?php

namespace Src\BC\Author\UI\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BC\Author\Application\UseCase\ListAuthorPostsUseCase;

class ListAuthorPostsController extends Controller
{
    public function __construct(private ListAuthorPostsUseCase $useCase) {}

    public function __invoke(string $id, Request $request): JsonResponse
    {   
        try {
            $page     = (int) $request->query('page', 1);
            $perPage  = (int) $request->query('perPage', 10);

            $orderParam = $request->query('order', '-publishDate');
            $direction = str_starts_with($orderParam, '-') ? 'desc' : 'asc';
            $orderInput = ltrim($orderParam, '+-');
            
            $orderMap = [
                'id'          => 'id',
                'subject'     => 'subject',
                'publishDate' => 'publish_date',
            ];
                
            $dbColumn = $orderMap[$orderInput] ?? 'publish_date';

            $result = $this->useCase->execute($id, $dbColumn, $direction, $page, $perPage);

            $posts = array_map(fn($post) => [
                'id'           => $post->getPostIdValue(),
                'authorId'     => $post->getAuthorIdValue(),
                'subject'      => $post->getSubjectValue(),
                'description'  => $post->getDescriptionValue(),
                'publishDate'  => $post->getPublishDateValue(),
                'status'       => $post->getStatusValue(),
                'numComments'  => $post->getNumCommentsValue(),
            ], $result['items']);
                    
            return response()->json([
                'status' => 'success',
                'data'   => $posts,
                'meta'   => $result['meta']       
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error'  => $e->getMessage()
            ], 404);
        }
    }
}