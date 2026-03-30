<?php

namespace Src\bc\Post\Infraestructure\Traits;

use Src\bc\Post\Domain\Entities\Post;
use Src\bc\Post\Infraestructure\Models\PostModel;

trait CreatePostTrait
{
    public function createPost(Post $post): void
    {
        PostModel::create([
            'id'           => $post->getPostIdValue(),
            'subject'      => $post->getSubjectValue(),
            'description'  => $post->getDescriptionValue(),
            'publish_date' => $post->getPublishDateValue(),
            'status'       => $post->getStatusValue(),
            'author_id'    => $post->getAuthorIdValue(),
            'num_comments' => $post->getNumCommentsValue(),
        ]);
    }
}