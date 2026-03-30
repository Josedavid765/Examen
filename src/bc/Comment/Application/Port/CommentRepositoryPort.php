<?php

namespace Src\bc\Comment\Application\Port;
use Src\bc\Comment\Domain\Entities\Comment;

interface CommentRepositoryPort
{
    public function createComment(Comment $comment): void;

    public function readComment(string $id):?Comment;

    public function updateComment(Comment $comment):void;

    public function deleteComment(string $id):void;
    
    public function listByPostID(string $postId):array;

    public function listCommentsByAuthorId(string $authorId):array;

    public function deleteCommentsByPostId(string $postId):void;

    public function deleteCommentsByAuthorIdBatch(string $authorId, int $limit):int;
}
