<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Domain\Entities\Post;
use Src\BC\Post\Infrastructure\Models\PostModel;

trait UpdatePostTrait
{
    public function updatePost(Post $post): void
    {
        $postModel = PostModel::find($post->getPostIdValue());

        if ($postModel) {
            $postModel->update([
                'author_id'    => $post->getAuthorIdValue(),
                'subject'      => $post->getSubjectValue(),
                'description'  => $post->getDescriptionValue(),
                'publish_date' => $post->getPublishDateValue(),
                'status'       => $post->getStatusValue(),
                'num_comments' => $post->getNumCommentsValue(),
            ]);
        }
    }
}
