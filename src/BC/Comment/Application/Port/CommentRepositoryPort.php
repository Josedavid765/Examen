<?php

namespace Src\BC\Comment\Application\Port;
use Src\BC\Comment\Domain\Entities\Comment;

interface CommentRepositoryPort
{
    public function createComment(Comment $comment): void;

    public function readComment(\Src\BC\Comment\Domain\ValueObject\CommentIdValueObject $id):?Comment;

    public function updateComment(Comment $comment):void;

    public function deleteComment(\Src\BC\Comment\Domain\ValueObject\CommentIdValueObject $id):void;

    public function listByPostID(\Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject $postId):array;

    public function listCommentsByAuthorId(\Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject $authorId):array;

    public function deleteCommentsByPostId(\Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject $postId):void;

    public function deleteCommentsByAuthorIdBatch(\Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject $authorId, int $limit):int;
}
