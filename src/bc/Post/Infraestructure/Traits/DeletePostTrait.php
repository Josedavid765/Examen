<?php

namespace Src\bc\Post\Infraestructure\Traits;

use Src\bc\Post\Domain\ValueObject\PostIdValueObject;
use Src\bc\Post\Infraestructure\Models\PostModel;

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
