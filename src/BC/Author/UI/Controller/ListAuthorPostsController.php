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
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('perPage', 10);

            $orderParam = $request->query('order', '-publishDate');
            $direction = str_starts_with($orderParam, '-') ? 'desc' : 'asc';
            $orderInput = ltrim($orderParam, '+-');

            $orderMap = [
                'id'          => 'id',
                'description' => 'description',
                'publishDate' => 'publish_date',
                'subject'     => 'subject'
            ];

            $dbColumn = $orderMap[$orderInput] ?? 'publish_date';

            $result = $this->useCase->execute(
                $id,
                $dbColumn,
                $direction,
                $page,
                $perPage
            );

            $mappedItems = array_map(function ($item) {
                $post = $item['post'];
                $author = $item['author'];

                $authorData = null;
                if ($author) {
                    $authorData = [
                        'id' => $author->getAuthorIdValue(),
                        'fullName' => $author->getFullName(),
                        'firstName' => $author->getAuthorFirstNameValue(),
                        'lastName' => $author->getAuthorLastNameValue()
                    ];
                }
                return [
                    'id'           => $post->getPostIdValue(),
                    'authorId'     => $post->getAuthorIdValue(),
                    'author'       => $authorData,
                    'subject'      => $post->getSubjectValue(),
                    'description'  => $post->getDescriptionValue(),
                    'publishDate'  => $post->getPublishDateValue(),
                    'status'       => $post->getStatusValue(),
                    'numComments'  => $post->getNumCommentsValue(),
                ];
            }, $result['items']);

            return response()->json([
                'status'     => 'success',
                'data'       => $mappedItems,
                'meta' => $result['pagination']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}