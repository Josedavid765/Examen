<?php

namespace Src\BC\Post\Infrastructure\Traits;

use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Infrastructure\Models\PostModel;

trait DeletePostTrait
{
    public function deletePost(PostIdValueObject $id): void
    {
        $postModel = PostModel::find($id->value());

        if ($postModel) {
            $postModel->delete();
        }
    }
}
