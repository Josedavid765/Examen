<?php

namespace Src\BC\Post\Domain\Entities;

use Src\BC\Post\Domain\ValueObject\PostIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostSubjectValueObject;
use Src\BC\Post\Domain\ValueObject\PostDescriptionValueObject;
use Src\BC\Post\Domain\ValueObject\PostPublishDateValueObject;
use Src\BC\Post\Domain\ValueObject\PostStatusValueObject;
use Src\BC\Post\Domain\ValueObject\PostAuthorIdValueObject;
use Src\BC\Post\Domain\ValueObject\PostCommentCount;

class Post
{
    private PostIdValueObject $postId;
    private PostSubjectValueObject $subject;
    private PostDescriptionValueObject $description;
    private PostPublishDateValueObject $publishDate;
    private PostStatusValueObject $status;
    private PostAuthorIdValueObject $authorId;
    private PostCommentCount $numOfComments;

    public function __construct(
        PostIdValueObject $postId,
        PostSubjectValueObject $subject,
        PostDescriptionValueObject $description,
        PostPublishDateValueObject $publishDate,
        PostStatusValueObject $status,
        PostAuthorIdValueObject $authorId,
        PostCommentCount $numOfComments
    ) {
        $this->postId = $postId;
        $this->subject = $subject;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->status = $status;
        $this->authorId = $authorId;
        $this->numOfComments = $numOfComments;
    }

    public function getPostId(): PostIdValueObject { return $this->postId; }
    public function getPostIdValue(): string { return $this->postId->value(); }

    public function getSubject(): PostSubjectValueObject { return $this->subject; }
    public function getSubjectValue(): string { return $this->subject->value(); }

    public function getDescription(): PostDescriptionValueObject { return $this->description; }
    public function getDescriptionValue (): string { return $this->description->value(); }

    public function getPublishDate(): PostPublishDateValueObject { return $this->publishDate; }    
    public function getPublishDateValue(): string { return $this->publishDate->value(); }
    
    public function getStatus(): PostStatusValueObject { return $this->status; }
    public function getStatusValue(): string { return $this->status->value(); }

    public function getAuthorId(): PostAuthorIdValueObject { return $this->authorId; }
    public function getAuthorIdValue(): string { return $this->authorId->value(); }

    public function getNumComments(): PostCommentCount { return $this->numOfComments; }
    public function getNumCommentsValue(): int { return $this->numOfComments->value(); }

    public function changeStatus(PostStatusValueObject $newStatus): void
    {
        if ($this->status->isCancelled()) {
            throw new \DomainException("No se puede cambiar el estado de un post que ya ha sido cancelado.");
        }

        if ($this->status->equals($newStatus)) {
            return;
        }
        
        $this->status = $newStatus;
    }

    public function addComment(): void
    {
        $this->numOfComments = $this->numOfComments->increment();
    }

    public function removeComment(): void
    {
        $this->numOfComments = $this->numOfComments->decrement();
    }
}