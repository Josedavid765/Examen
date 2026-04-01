<?php

namespace Src\bc\Comment\Application\DTO;

class CommentUpdateDTO
{
    public function __construct(
        private ?string $id,
        private ?string $description,
        private ?string $authorId,
        private ?string $status,
        private ?string $postId,
        private ?string $commentDate,
    ) {}

    public function getId(): ?string { return $this->id; }
    public function getDescription(): ?string { return $this->description; }
    public function getAuthorId(): ?string { return $this->authorId; }
    public function getStatus(): ?string { return $this->status; }
    public function getPostId(): ?string { return $this->postId; }
    public function getCommentDate(): ?string { return $this->commentDate; }
}
