<?php

namespace Src\BC\Post\UI\Controller;

use Illuminate\Http\JsonResponse;
use Src\BC\Post\Application\UseCase\ListPostsUseCase;
use Illuminate\Http\Request;

class ListPostsController
{
    public function __construct(
        private ListPostsUseCase $listPostsUseCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('perPage', 10);

            $orderParam = $request->query('order', '-publishDate');
            $direction = str_starts_with($orderParam, '-') ? 'desc' : 'asc';
            $orderInput = ltrim($orderParam, '+-');

            $orderMap = [
                'id'          => 'id',
                'subject'     => 'subject',
                'publishDate' => 'publish_date',
                'status'      => 'status'
            ];

            $order = $orderMap[$orderInput] ?? 'publishDate';

            $result = $this->listPostsUseCase->execute($order, $direction, $page, $perPage);

            $data = array_map(function ($post) {
                return [
                    'id'           => $post->getPostIdValue(),
                    'authorId'    => $post->getAuthorIdValue(),
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publishDate' => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'numComments' => $post->getNumCommentsValue(),
                    'authorName' => $post->getAuthorFullNameValue(),
                ];
            }, $result['items']);

            return response()->json([
                'status' => 'success',
                'data'   => $data,
                'meta'   => $result['pagination']
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error','error'  => $e->getMessage()], 400);
        }
    }
}
