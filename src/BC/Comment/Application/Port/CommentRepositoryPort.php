<?php

namespace Src\BC\Comment\Application\Port;
use Src\BC\Comment\Domain\Entities\Comment;
use \Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;
use \Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;

interface CommentRepositoryPort
{
    public function createComment(Comment $comment): void;

    public function readComment(CommentIdValueObject $id):?Comment;

    public function updateComment(Comment $comment):void;

    public function deleteComment(CommentIdValueObject $id):void;

    public function listCommentsByAuthorId(string $authorId, 
        int $limit = 10, 
        int $offset = 0,
        string $order = 'comment_date',
        string $direction = 'desc'):array;

    public function deleteCommentsByAuthorIdBatch(string $authorId, int $limit):int;
    
    public function listByPostID(CommentPostIdValueObject $postId, string $order = 'commentDate', string $direction = 'desc', int $page = 1, int $perPage = 10):array;
    
    public function deleteCommentsByPostId(string $postId):void;
}
