<?php

namespace Src\BC\Post\Application\DTO;

class PostUpdateDTO
{
    public function __construct(
        private ?string $postId,
        private ?string $subject,
        private ?string $description,
        private ?string $publishDate,
        private ?string $status,
        private ?string $authorId,
        private ?int $numComments
    ){}

    public function getPostId(): ?string {return $this->postId; }
    public function getSubject(): ?string {return $this->subject; }
    public function getDescription(): ?string {return $this->description; }
    public function getPublishDate(): ?string {return $this->publishDate; }
    public function getStatus(): ?string {return $this->status; }
    public function getAuthorId(): ?string {return $this->authorId; }
    public function getNumComments(): ?int {return $this->numComments; }
}
