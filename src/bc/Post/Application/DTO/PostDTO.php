<?php

namespace Src\bc\Post\Application\DTO;

class PostDTO
{
    public function __construct(
        private string $postID,
        private string $subject,
        private string $description,
        private string $publishDate,
        private string $status,
        private string $authorId,
        private int $numComments
    ){}

    public function getPostId(): string {return $this->postID; }
    public function getsubject(): string {return $this->subject; }
    public function getDescription(): string {return $this->description; }
    public function getPublishdate(): string {return $this->publishDate; }
    public function getStatus(): string {return $this->status; }
    public function getAuthorId(): string {return $this->authorId; }
    public function getNumComments(): int {return $this->numComments; }
}
