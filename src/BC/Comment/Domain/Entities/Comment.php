<?php

namespace Src\BC\Comment\Domain\Entities;

use Src\BC\Comment\Domain\ValueObject\CommentAuthorFullNameValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentAuthorIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentDateValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentDescriptionValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentPostIdValueObject;
use Src\BC\Comment\Domain\ValueObject\CommentStatusValueObject;

class Comment
{
    private CommentIdValueObject $commentId;
    private CommentDescriptionValueObject $description;
    private CommentAuthorIdValueObject $authorId;
    private CommentStatusValueObject $status;
    private CommentPostIdValueObject $postId;
    private CommentDateValueObject $commentdate;
    private CommentAuthorFullNameValueObject $authorfullName;


    public function __construct(
        CommentIdValueObject $commentId, 
        CommentDescriptionValueObject $description,
        CommentAuthorIdValueObject $authorId,
        CommentStatusValueObject $status,
        CommentPostIdValueObject $postId,
        CommentDateValueObject $commentdate,
        CommentAuthorFullNameValueObject $authorfullName
    ) {
        $this->commentId = $commentId;
        $this->description = $description;
        $this->authorId = $authorId;
        $this->status = $status;
        $this->postId = $postId;
        $this->commentdate = $commentdate;
        $this->authorfullName = $authorfullName;
    }

    public function getCommentId(): CommentIdValueObject { return $this->commentId; }
    public function getCommentIdValue(): string { return $this->commentId->value(); }

    public function getDescription(): CommentDescriptionValueObject { return $this->description; }
    public function getDescriptionValue(): string { return $this->description->value(); }

    public function getAuthorId(): CommentAuthorIdValueObject { return $this->authorId; }
    public function getAuthorIdValue(): string { return $this->authorId->value(); }

    public function getStatus(): CommentStatusValueObject { return $this->status; }
    public function getStatusValue(): string { return $this->status->value(); }

    public function getPostId(): CommentPostIdValueObject { return $this->postId; }
    public function getPostIdValue(): string { return $this->postId->value(); }

    public function getCommentDate(): CommentDateValueObject { return $this->commentdate; }
    public function getCommentDateValue(): string { return $this->commentdate->value(); }

    public function getAuthorFullName(): CommentAuthorFullNameValueObject { return $this->authorfullName; }
    public function getAuthorFullNameValue(): string { return $this->authorfullName->value(); }

    public function changeStatus(CommentStatusValueObject $newStatus): void
    {
        if ($this->status->isCancelled()) {
            throw new \DomainException("No se puede cambiar el estado de un post que ya ha sido cancelado.");
        }

        if ($this->status->equals($newStatus)) {
            return;
        }
        
        $this->status = $newStatus;
    }

    public function updateDescription(CommentDescriptionValueObject $description): void { $this->description = $description; }
}
